<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\Team;

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
                'value' => Event::count(),
                'detail' => "{$upcomingEventCount} event mendatang",
                'icon' => 'bi-calendar-event',
                'iconStyle' => 'background-color: #e0f2fe; color: #0284c7;',
            ],
            [
                'label' => 'Total Tim',
                'value' => Team::count(),
                'detail' => "{$publishedTeamCount} dipublikasikan",
                'icon' => 'bi-people',
                'iconStyle' => 'background-color: #ede9fe; color: #7c3aed;',
            ],
            [
                'label' => 'Sponsor Aktif',
                'value' => $activeSponsorCount,
                'detail' => Sponsor::count() . ' total sponsor',
                'icon' => 'bi-star',
                'iconStyle' => 'background-color: #fef3c7; color: #d97706;',
            ],
            [
                'label' => 'Total Gallery',
                'value' => $galleryCount,
                'detail' => "{$galleryCount} item tersimpan",
                'icon' => 'bi-image',
                'iconStyle' => 'background-color: #d1fae5; color: #059669;',
            ],
        ];

        $contentSummary = [
            ['label' => 'Categories', 'value' => Category::count()],
            ['label' => 'Services', 'value' => Service::count()],
            ['label' => 'Partners', 'value' => Partner::count()],
            ['label' => 'Teams', 'value' => Team::count()],
        ];

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
            'contentSummary' => $contentSummary,
            'totalContent' => collect($contentSummary)->sum('value'),
            'topSponsors' => Sponsor::withCount('events')
                ->orderByDesc('events_count')
                ->orderBy('name')
                ->limit(4)
                ->get(),
            'recentActivities' => $activityRecords,
        ]);
    }
}