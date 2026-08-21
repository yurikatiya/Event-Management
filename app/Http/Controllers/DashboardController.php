<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Sponsor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $eventPerformance = Event::query()
            ->selectRaw('MONTH(start_date) as month, COUNT(*) as total')
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

        return view('admin.dashboard', [
            'metrics' => [
                'events' => Event::count(),
                'activeEvents' => Event::whereIn('status', ['upcoming', 'ongoing', 'approved'])->count(),
                'galleries' => Gallery::count(),
                'articles' => Schema::hasTable('articles') ? Schema::getConnection()->table('articles')->count() : 0,
                'partners' => Sponsor::count(),
            ],
            'recentEvents' => Event::with('category')->latest()->limit(5)->get(),
            'upcomingEvents' => Event::with('category')->whereIn('status', ['upcoming', 'approved'])->whereDate('start_date', '>=', today())->orderBy('start_date')->limit(4)->get(),
            'statusCounts' => Event::query()->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
            'recentArticles' => $articles,
            'categoryEventCounts' => $categoryEventCounts,
            'recentGalleries' => Gallery::with('event')->latest()->limit(5)->get(),
            'recentPartners' => Sponsor::latest()->limit(5)->get(),
            'recentContacts' => $contacts,
            'recentActivities' => Event::latest()->limit(5)->get(['id', 'name', 'status', 'created_at']),
            'monthlyLabels' => $monthlyLabels,
            'monthlyTotals' => $monthlyTotals,
            'contactCount' => Schema::hasTable('contacts') ? Schema::getConnection()->table('contacts')->count() : 0,
        ]);
    }
}