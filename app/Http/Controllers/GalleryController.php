<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('admin.gallery.index', [
            'galleries' => $galleries,
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:published,draft'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul foto wajib diisi.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'file_path' => $path,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:published,draft'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul foto wajib diisi.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->file_path) {
                Storage::disk('public')->delete($gallery->file_path);
            }

            $validated['file_path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'file_path' => $validated['file_path'] ?? $gallery->file_path,
        ]);

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
