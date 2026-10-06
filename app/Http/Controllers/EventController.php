<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::with('category')
            ->withCount(['galleries as published_galleries_count' => fn ($query) => $query->where('status', 'published')])
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->string('search') . '%'))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('start_date')
            ->paginate(10)
            ->withQueryString();
        $galleryPreviews = Gallery::query()
            ->whereIn('event_id', $events->getCollection()->modelKeys())
            ->where('status', 'published')
            ->latest()
            ->get(['event_id', 'file_path', 'caption'])
            ->groupBy('event_id')
            ->map(fn ($photos) => $photos->take(3)->values());
        $events->getCollection()->each(fn (Event $event) => $event->setAttribute(
            'gallery_previews',
            $galleryPreviews->get($event->id, collect()),
        ));

        return view('admin.events.index', [
            'events' => $events,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'categories' => Category::orderBy('name')->get(),
            'sponsors' => Sponsor::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['poster'] = $request->file('poster')?->store('events', 'public');
        $event = Event::create($data + ['created_by' => $request->user()->id]);
        $event->sponsors()->sync($request->input('sponsor_ids', []));

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
            'categories' => Category::orderBy('name')->get(),
            'sponsors' => Sponsor::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $this->validatedData($request);
        $oldPoster = $event->poster;
        if ($request->hasFile('poster')) {
            $newPoster = $request->file('poster')->store('events', 'public');
            if (! $newPoster) {
                throw new RuntimeException('Cover event gagal disimpan ke penyimpanan.');
            }

            $data['poster'] = $newPoster;
        } else {
            unset($data['poster']);
        }
        $event->update($data);
        $event->sponsors()->sync($request->input('sponsor_ids', []));

        if (isset($newPoster) && $oldPoster) {
            Storage::disk('public')->delete($oldPoster);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'sponsor_ids' => ['nullable', 'array'],
            'sponsor_ids.*' => ['integer', 'exists:sponsors,id'],
            'status' => ['required', 'in:draft,published,archived,upcoming,completed,pending,approved,rejected'],
        ]);
    }
}