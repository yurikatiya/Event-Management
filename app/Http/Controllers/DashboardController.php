<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\DashboardCalendarNote;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        $upcomingEventCount = Event::query()
            ->whereIn('status', ['published', 'upcoming', 'approved'])
            ->whereDate('start_date', '>=', today())
            ->count();
        $publishedTeamCount = Team::where('status', 'published')->count();
        $activeSponsorCount = Sponsor::whereIn('status', ['active', 'published'])->count();
        $galleryCount = Gallery::count();

        $stats = [
            [
                'label' => 'Total Events',
                'url' => route('admin.events.index'),
                'value' => Event::count(),
                'detail' => "{$upcomingEventCount} event mendatang",
                'icon' => 'bi-calendar-event',
                'iconStyle' => 'background-color: #e0f2fe; color: #0284c7;',
            ],
            [
                'label' => 'Total Tim',
                'url' => route('admin.teams.index'),
                'value' => Team::count(),
                'detail' => "{$publishedTeamCount} dipublikasikan",
                'icon' => 'bi-people',
                'iconStyle' => 'background-color: #ede9fe; color: #7c3aed;',
            ],
            [
                'label' => 'Sponsor Aktif',
                'url' => route('admin.sponsors.index'),
                'value' => $activeSponsorCount,
                'detail' => Sponsor::count() . ' total sponsor',
                'icon' => 'bi-star',
                'iconStyle' => 'background-color: #fef3c7; color: #d97706;',
            ],
            [
                'label' => 'Total Gallery',
                'url' => route('admin.gallery.index'),
                'value' => $galleryCount,
                'detail' => "{$galleryCount} item tersimpan",
                'icon' => 'bi-image',
                'iconStyle' => 'background-color: #d1fae5; color: #059669;',
            ],
        ];

        $currentYear = now()->year;
        $availableEventYears = Event::query()
            ->whereNotNull('start_date')
            ->get(['start_date'])
            ->map(fn (Event $event) => $event->start_date->year)
            ->unique()
            ->sort()
            ->toBase()
            ->values();

        if ($availableEventYears->isEmpty()) {
            $availableEventYears->push($currentYear);
        }

        $defaultChartYear = $availableEventYears->last();
        $requestedChartYear = request()->integer('chart_year', $defaultChartYear);
        $chartYear = $availableEventYears->contains($requestedChartYear)
            ? $requestedChartYear
            : $defaultChartYear;
        $chartYearIndex = $availableEventYears->search($chartYear);
        $previousChartYear = $chartYearIndex > 0 ? $availableEventYears->get($chartYearIndex - 1) : null;
        $nextChartYear = $chartYearIndex < $availableEventYears->count() - 1
            ? $availableEventYears->get($chartYearIndex + 1)
            : null;
        $eventCountsByMonth = Event::query()
            ->whereYear('start_date', $chartYear)
            ->get(['start_date'])
            ->countBy(fn (Event $event) => $event->start_date->month);
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyEventSummary = collect(range(1, 12))
            ->map(fn (int $month) => [
                'month' => $month,
                'label' => $monthLabels[$month - 1],
                'value' => $eventCountsByMonth->get($month, 0),
            ])
            ->all();
        $yearStart = now()->startOfYear()->toDateString();
        $yearEnd = now()->endOfYear()->toDateString();
        $calendarEvents = Event::query()
            ->whereNotNull('start_date')
            ->where(function ($query) use ($yearStart, $yearEnd) {
                $query->whereBetween('start_date', [$yearStart, $yearEnd])
                    ->orWhere(function ($query) use ($yearStart) {
                        $query->whereDate('start_date', '<', $yearStart)
                            ->whereDate('end_date', '>=', $yearStart);
                    });
            })
            ->orderBy('start_date')
            ->get(['name', 'start_date', 'end_date'])
            ->map(fn (Event $event) => [
                'name' => $event->name,
                'startDate' => $event->start_date->format('Y-m-d'),
                'endDate' => ($event->end_date ?? $event->start_date)->format('Y-m-d'),
            ])
            ->values();
        $calendarNotes = DashboardCalendarNote::query()
            ->where('user_id', auth()->id())
            ->whereYear('note_date', $currentYear)
            ->get(['note_date', 'note'])
            ->mapWithKeys(fn (DashboardCalendarNote $calendarNote) => [
                $calendarNote->note_date->format('Y-m-d') => $calendarNote->note,
            ])
            ->all();

        $activityRecords = collect()
            ->concat(Event::latest('created_at')->limit(5)->get()->map(fn (Event $event) => [
                'label' => $event->name,
                'type' => 'Event ditambahkan',
                'created_at' => $event->created_at,
                'icon' => 'bi-calendar-event',
                'tone' => 'sky',
            ]))
            ->concat(Gallery::with('event')
                ->latest('created_at')
                ->limit(5)
                ->get(['id', 'event_id', 'file_path', 'caption', 'created_at'])
                ->map(fn (Gallery $gallery) => [
                'label' => $gallery->caption ?: $gallery->event?->name ?: basename($gallery->file_path),
                'type' => 'Gallery ditambahkan',
                'created_at' => $gallery->created_at,
                'icon' => 'bi-images',
                'tone' => 'emerald',
            ]))
            ->concat(Sponsor::latest('created_at')->limit(5)->get()->map(fn (Sponsor $sponsor) => [
                'label' => $sponsor->name,
                'type' => 'Sponsor ditambahkan',
                'created_at' => $sponsor->created_at,
                'icon' => 'bi-star',
                'tone' => 'amber',
            ]))
            ->concat(Partner::latest('created_at')->limit(5)->get()->map(fn (Partner $partner) => [
                'label' => $partner->name,
                'type' => 'Partner ditambahkan',
                'created_at' => $partner->created_at,
                'icon' => 'bi-buildings',
                'tone' => 'blue',
            ]))
            ->concat(Team::latest('created_at')->limit(5)->get()->map(fn (Team $team) => [
                'label' => $team->name,
                'type' => 'Anggota tim ditambahkan',
                'created_at' => $team->created_at,
                'icon' => 'bi-person',
                'tone' => 'violet',
            ]))
            ->concat(Service::latest('created_at')->limit(5)->get()->map(fn (Service $service) => [
                'label' => $service->name,
                'type' => 'Layanan ditambahkan',
                'created_at' => $service->created_at,
                'icon' => 'bi-grid',
                'tone' => 'cyan',
            ]))
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentEvents' => Event::with('category')->latest('created_at')->limit(5)->get(),
            'monthlyEventSummary' => $monthlyEventSummary,
            'currentYear' => $currentYear,
            'chartYear' => $chartYear,
            'previousChartYear' => $previousChartYear,
            'nextChartYear' => $nextChartYear,
            'yearEventCount' => $eventCountsByMonth->sum(),
            'calendarEvents' => $calendarEvents,
            'calendarNotes' => $calendarNotes,
            'topSponsors' => Sponsor::withCount('events')
                ->orderByDesc('events_count')
                ->orderBy('name')
                ->limit(4)
                ->get(),
            'recentActivities' => $activityRecords,
        ]);
    }

    public function storeCalendarNote(Request $request): JsonResponse
    {
        $date = $this->validatedCalendarNoteDate($request);
        $validated = $request->validate([
            'note' => ['required', 'string', 'max:1000'],
        ]);

        $calendarNote = DashboardCalendarNote::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('note_date', $date)
            ->first();

        if ($calendarNote) {
            $calendarNote->update(['note' => trim($validated['note'])]);
        } else {
            $calendarNote = DashboardCalendarNote::create([
                'user_id' => $request->user()->id,
                'note_date' => $date,
                'note' => trim($validated['note']),
            ]);
        }

        return response()->json([
            'date' => $calendarNote->note_date->format('Y-m-d'),
            'note' => $calendarNote->note,
        ]);
    }

    public function destroyCalendarNote(Request $request): JsonResponse
    {
        $date = $this->validatedCalendarNoteDate($request);

        DashboardCalendarNote::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('note_date', $date)
            ->delete();

        return response()->json(['date' => $date, 'deleted' => true]);
    }

    private function validatedCalendarNoteDate(Request $request): string
    {
        $validated = $request->validate([
            'date' => ['required', 'date_format:Y-m-d'],
        ]);

        if ((int) substr($validated['date'], 0, 4) !== now()->year) {
            throw ValidationException::withMessages([
                'date' => 'Catatan hanya dapat dibuat untuk tahun berjalan.',
            ]);
        }

        return $validated['date'];
    }
}