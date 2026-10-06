<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $photos = Gallery::with('event')->latest()->get();
        $albums = $photos
            ->groupBy(fn (Gallery $photo) => $photo->event_id ? 'event-' . $photo->event_id : 'unassigned')
            ->map(function (Collection $albumPhotos) {
                $event = $albumPhotos->first()->event;

                return [
                    'key' => $event ? 'event-' . $event->id : 'unassigned',
                    'event' => $event,
                    'name' => $event?->name ?? 'Dokumentasi tanpa event',
                    'photos' => $albumPhotos->values(),
                ];
            })
            ->values();
        $selectedAlbumKey = $request->query('album');
        $selectedAlbum = $selectedAlbumKey
            ? $albums->firstWhere('key', $selectedAlbumKey)
            : null;

        if (! $selectedAlbum) {
            $selectedAlbumKey = null;
        }

        if ($selectedAlbum) {
            $selectedAlbum['photos'] = $selectedAlbum['photos']
                ->filter(fn (Gallery $photo) => $search === ''
                    || stripos($photo->caption ?? '', $search) !== false
                    || stripos($photo->title ?? '', $search) !== false)
                ->values();
        } elseif (! $selectedAlbumKey) {
            $albums = $albums->filter(function (array $album) use ($search) {
                if ($search === '') {
                    return true;
                }

                return stripos($album['name'], $search) !== false
                    || $album['photos']->contains(fn (Gallery $photo) =>
                        stripos($photo->caption ?? '', $search) !== false
                        || stripos($photo->title ?? '', $search) !== false
                    );
            })->values();
        }

        $perPage = 12;
        $page = LengthAwarePaginator::resolveCurrentPage();
        if (! $selectedAlbum) {
            $albums = new LengthAwarePaginator(
                $albums->forPage($page, $perPage)->values(),
                $albums->count(),
                $perPage,
                $page,
                ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()],
            );
        }

        return view('admin.gallery.index', [
            'albums' => $albums,
            'selectedAlbum' => $selectedAlbum,
            'photoCount' => $photos->count(),
        ]);
    }

    public function create(Request $request): View
    {
        $preselectedEvent = $request->filled('event_id')
            ? Event::findOrFail($request->query('event_id'))
            : null;

        return view('admin.gallery.create', [
            'events' => Event::orderByDesc('start_date')->orderBy('name')->get(),
            'preselectedEvent' => $preselectedEvent,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:published,draft'],
            'images' => ['required', 'array', 'min:1', 'max:15'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'event_id.required' => 'Pilih event untuk album ini.',
            'images.required' => 'Pilih minimal satu foto dokumentasi.',
            'images.min' => 'Pilih minimal satu foto dokumentasi.',
            'images.max' => 'Maksimal 15 foto dalam satu album.',
            'images.*.image' => 'Semua file yang diupload harus berupa gambar.',
            'images.*.max' => 'Ukuran setiap foto maksimal 2 MB.',
        ]);

        $event = Event::findOrFail($validated['event_id']);
        $storedPaths = [];

        try {
            DB::transaction(function () use ($request, $validated, $event, &$storedPaths): void {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('gallery/events/' . $event->id, 'public');
                    if (! $path) {
                        throw new RuntimeException('Foto gagal disimpan ke penyimpanan galeri.');
                    }

                    $storedPaths[] = $path;

                    Gallery::create([
                        'event_id' => $event->id,
                        'title' => $event->name,
                        'caption' => $image->getClientOriginalName(),
                        'description' => $validated['description'] ?? null,
                        'status' => $validated['status'],
                        'file_path' => $path,
                    ]);
                }
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($storedPaths);
            throw $exception;
        }

        return redirect()
            ->route('admin.gallery.index', ['album' => 'event-' . $event->id])
            ->with('success', count($request->file('images')) . ' foto berhasil ditambahkan ke album ' . $event->name . '.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', [
            'gallery' => $gallery,
            'events' => Event::orderByDesc('start_date')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'event_id' => ['nullable', 'exists:events,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:published,draft'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul foto wajib diisi.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $oldFilePath = $gallery->file_path;
        $newFilePath = null;

        try {
            DB::transaction(function () use ($request, $validated, $gallery, &$newFilePath): void {
                if ($request->hasFile('image')) {
                    $newFilePath = $request->file('image')->store('gallery', 'public');
                    if (! $newFilePath) {
                        throw new RuntimeException('Foto gagal disimpan ke penyimpanan galeri.');
                    }
                }

                $gallery->update([
                    'event_id' => $validated['event_id'] ?? null,
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'status' => $validated['status'],
                    'file_path' => $newFilePath ?? $oldFilePath,
                ]);
            });
        } catch (Throwable $exception) {
            if ($newFilePath) {
                Storage::disk('public')->delete($newFilePath);
            }

            throw $exception;
        }

        if ($newFilePath && $oldFilePath) {
            Storage::disk('public')->delete($oldFilePath);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil dihapus.');
    }
}
