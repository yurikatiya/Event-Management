@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $statusClasses = [
        'draft' => 'bg-slate-100 text-slate-600',
        'published' => 'bg-emerald-50 text-emerald-600',
        'upcoming' => 'bg-sky-50 text-sky-600',
        'approved' => 'bg-blue-50 text-blue-600',
        'completed' => 'bg-violet-50 text-violet-600',
        'archived' => 'bg-slate-100 text-slate-500',
        'pending' => 'bg-amber-50 text-amber-600',
        'rejected' => 'bg-rose-50 text-rose-600',
    ];
    $summaryScale = max(1, collect($contentSummary)->max('value'));
@endphp

<div class="dashboard-page dashboard-shell-content">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Dashboard</h1>
            <p class="mt-1 text-base text-slate-400">Selamat datang kembali, {{ auth()->user()->name }}. Ini ringkasan hari ini.</p>
        </header>

        <section class="dashboard-stats-grid grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
            <article class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-stat-card dashboard-stat-card-{{ $loop->iteration }}">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Overview</p>
                            <p class="mt-2 text-sm font-semibold text-slate-600">{{ $stat['label'] }}</p>
                        </div>
                        <span class="stat-card-icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl" style="{{ $stat['iconStyle'] }}"><i class="bi {{ $stat['icon'] }} text-lg"></i></span>
                    </div>
                    <div class="mt-6 flex items-end justify-between gap-3">
                        <p class="text-4xl font-extrabold tracking-tight text-slate-900">{{ $stat['value'] }}</p>
                        <span class="stat-card-arrow" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span>
                    </div>
                    <p class="mt-3 text-xs font-semibold text-slate-500">{{ $stat['detail'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="dashboard-primary-grid mt-10 grid grid-cols-1 items-stretch gap-6 mb-6 lg:grid-cols-3">
            <article class="dashboard-white-card lg:col-span-2 flex h-full flex-col rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Event Terbaru</h2>
                <div class="mt-6 flex-1 divide-y divide-slate-100">
                    @forelse ($recentEvents as $event)
                        @php($status = strtolower($event->status ?? 'draft'))
                        <div class="flex items-center gap-4 py-3.5 first:pt-0 last:pb-0">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold uppercase text-sky-600">{{ \Illuminate\Support\Str::substr($event->name, 0, 2) }}</span>
                            <div class="min-w-0 flex-1"><p class="truncate text-base font-bold text-slate-800">{{ $event->name }}</p><p class="mt-0.5 truncate text-sm text-slate-400">{{ $event->category?->name ?? 'Tanpa kategori' }}{{ $event->start_date ? ' · ' . $event->start_date->translatedFormat('d M Y') : '' }}</p></div>
                            <span class="shrink-0 rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-600' }}">{{ ucfirst($status) }}</span>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-400">Belum ada event di database.</p>
                    @endforelse
                </div>
            </article>

            <article class="dashboard-highlight-card lg:col-span-1 flex h-full flex-col gap-4 overflow-hidden rounded-3xl border border-sky-500 bg-sky-500 p-6 text-white shadow-sm">
                <div>
                    <h2 class="text-lg font-bold text-white">Ringkasan Konten</h2>
                    <p class="mt-1 text-sm text-sky-50">Status semua konten CMS</p>
                </div>
                <div class="w-full space-y-4">
                    @foreach ($contentSummary as $item)
                        <div class="w-full">
                            <div class="mb-1.5 flex items-center justify-between gap-3 text-sm text-white"><span>{{ $item['label'] }}</span><strong>{{ $item['value'] }}</strong></div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-white/25">
                                <div class="h-full max-w-full rounded-full bg-white" style="width: {{ ($item['value'] / $summaryScale) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-auto w-full border-t border-white/30 pt-4 text-sm font-medium text-white">Total konten terdaftar: {{ $totalContent }}</div>
            </article>
        </section>

        <section class="dashboard-secondary-grid mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <article class="dashboard-white-card rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Sponsor Teratas</h2>
                <div class="mt-5 divide-y divide-slate-50">
                    @forelse ($topSponsors as $sponsor)
                        <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sm font-semibold text-sky-600">{{ $loop->iteration }}</span><div class="min-w-0 flex-1"><p class="truncate text-base text-slate-600">{{ $sponsor->name }}</p><p class="mt-0.5 text-xs text-slate-400">{{ $sponsor->tier ?: 'Sponsor' }}</p></div><span class="shrink-0 rounded-full bg-sky-50 px-3 py-1 text-xs font-medium text-sky-600">{{ $sponsor->events_count }} event</span></div>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400">Belum ada sponsor di database.</p>
                    @endforelse
                </div>
            </article>

            <article class="dashboard-white-card rounded-3xl border border-slate-100 bg-white p-6 shadow-sm dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Aktivitas Terkini</h2>
                <div class="mt-5 divide-y divide-slate-50">
                    @forelse ($recentActivities as $activity)
                        <div class="flex gap-4 py-3.5 first:pt-0 last:pb-0"><span class="mt-1.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-50 text-slate-500"><i class="bi {{ $activity['icon'] }}"></i></span><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-700">{{ $activity['label'] }}</p><p class="mt-1 text-xs text-slate-400">{{ $activity['type'] }} · {{ $activity['created_at']?->diffForHumans() ?? 'Tanggal tidak tersedia' }}</p></div></div>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400">Belum ada aktivitas untuk ditampilkan.</p>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
</div>
@endsection
