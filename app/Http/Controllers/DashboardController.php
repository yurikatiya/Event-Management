<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Sponsor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $monthExpression = Schema::getConnection()->getDriverName() === 'sqlite'
            ? "CAST(strftime('%m', start_date) AS INTEGER)"
            : 'MONTH(start_date)';

        $eventPerformance = Event::query()
            ->selectRaw("{$monthExpression} as month, COUNT(*) as total")
            ->whereYear('start_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyLabels = collect(range(1, 12))->map(fn (int $month) => Carbon::create()->month($month)->format('M'));
        $monthlyTotals = collect(range(1, 12))->map(fn (int $month) => (int) ($eventPerformance[$month] ?? 0));
        $articles = Schema::hasTable('articles')
            ? Schema::getConnection()->table('articles')->latest()->limit(5)->get()
            : collect();
        $contacts = Schema::hasTable('contacts')
            ? Schema::getConnection()->table('contacts')->latest()->limit(5)->get()
            : collect();
        $categoryEventCounts = Category::withCount('events')->orderByDesc('events_count')->limit(6)->get();
        $eventActivities = Event::query()
            ->latest('created_at')
            ->limit(5)
            ->get(['id', 'name', 'status', 'created_at'])
            ->map(fn (Event $event) => [
                'icon' => 'bi-calendar-plus',
                'title' => 'New event added',
                'description' => "{$event->name} was added",
                'created_at' => $event->created_at,
                'tone' => 'blue',
            ]);
        $partnerActivities = Partner::query()
            ->latest('updated_at')
            ->limit(5)
            ->get(['id', 'name', 'updated_at'])
            ->map(fn (Partner $partner) => [
                'icon' => 'bi-buildings',
                'title' => 'Partner updated',
                'description' => "{$partner->name} information updated",
                'created_at' => $partner->updated_at,
                'tone' => 'green',
            ]);
        $recentActivities = $eventActivities->concat($partnerActivities)->sortByDesc('created_at')->take(5)->values();

        return view('admin.dashboard', [
            'metrics' => [
                'events' => Event::count(),
                'upcomingEvents' => Event::whereIn('status', ['upcoming', 'approved'])->whereDate('start_date', '>=', today())->count(),
                'partners' => Partner::count(),
                'sponsors' => Sponsor::count(),
            ],
            'recentEvents' => Event::with('category')->latest()->limit(5)->get(),
            'upcomingEvents' => Event::with('category')->whereIn('status', ['upcoming', 'approved'])->whereDate('start_date', '>=', today())->orderBy('start_date')->limit(4)->get(),
            'statusCounts' => Event::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
            'recentArticles' => $articles,
            'categoryEventCounts' => $categoryEventCounts,
            'recentGalleries' => Gallery::with('event')->latest()->limit(5)->get(),
            'recentPartners' => Sponsor::latest()->limit(5)->get(),
            'recentContacts' => $contacts,
            'recentActivities' => $recentActivities,
            'monthlyLabels' => $monthlyLabels,
            'monthlyTotals' => $monthlyTotals,
            'contactCount' => Schema::hasTable('contacts') ? Schema::getConnection()->table('contacts')->count() : 0,
        ]);
    }
}