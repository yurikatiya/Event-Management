@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $stats = [
        ['label' => 'Total Events', 'value' => '48', 'trend' => '+12% vs bulan lalu', 'icon' => 'bi-calendar-event', 'iconStyle' => 'background-color: #e0f2fe; color: #0284c7;'],
        ['label' => 'Total Tim', 'value' => '24', 'trend' => '+3% vs bulan lalu', 'icon' => 'bi-person', 'iconStyle' => 'background-color: #ede9fe; color: #7c3aed;'],
        ['label' => 'Sponsor Aktif', 'value' => '16', 'trend' => '+8% vs bulan lalu', 'icon' => 'bi-star', 'iconStyle' => 'background-color: #fef3c7; color: #d97706;'],
        ['label' => 'Total Gallery', 'value' => '312', 'trend' => '+24% vs bulan lalu', 'icon' => 'bi-image', 'iconStyle' => 'background-color: #d1fae5; color: #059669;'],
    ];

    $events = [
        ['initials' => 'TE', 'name' => 'Tech Summit 2026', 'meta' => 'Technology · 20 Agt 2026', 'status' => 'Aktif', 'statusClass' => 'bg-emerald-50 text-emerald-600'],
        ['initials' => 'DE', 'name' => 'Design Week Jakarta', 'meta' => 'Design · 15 Sep 2026', 'status' => 'Draft', 'statusClass' => 'bg-amber-50 text-amber-600'],
        ['initials' => 'ST', 'name' => 'StartupFest Indonesia', 'meta' => 'Bisnis · 3 Okt 2026', 'status' => 'Aktif', 'statusClass' => 'bg-emerald-50 text-emerald-600'],
        ['initials' => 'HA', 'name' => 'Hackathon Nasional', 'meta' => 'Technology · 18 Okt 2026', 'status' => 'Segera', 'statusClass' => 'bg-sky-50 text-sky-600'],
        ['initials' => 'CR', 'name' => 'Creative Economy Expo', 'meta' => 'Ekonomi · 5 Nov 2026', 'status' => 'Draft', 'statusClass' => 'bg-amber-50 text-amber-600'],
    ];

    $sponsors = ['Telkom Indonesia', 'Bank BRI', 'Gojek', 'Tokopedia'];
    $contentSummary = [
        ['label' => 'Kategori', 'value' => 12],
        ['label' => 'Layanan', 'value' => 8],
        ['label' => 'Partner', 'value' => 20],
        ['label' => 'Tim', 'value' => 24],
    ];
    $activities = [
        ['label' => 'Event baru ditambahkan', 'time' => '2 menit lalu', 'dot' => 'bg-sky-400'],
        ['label' => 'Foto gallery diupload (12 foto)', 'time' => '35 menit lalu', 'dot' => 'bg-emerald-400'],
        ['label' => 'Sponsor baru: Bank BNI', 'time' => '1 jam lalu', 'dot' => 'bg-amber-400'],
        ['label' => 'Tim member diperbarui', 'time' => '3 jam lalu', 'dot' => 'bg-violet-400'],
    ];
@endphp

<div class="dashboard-page dashboard-shell-content">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Dashboard</h1>
            <p class="mt-1 text-base text-slate-400">Selamat datang kembali, Admin. Ini ringkasan hari ini.</p>
        </header>

        <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dashboard-stat-card">
                    <div class="flex items-start justify-between gap-4">
                        <p class="pt-2 text-sm font-medium uppercase tracking-wide text-slate-400">{{ $stat['label'] }}</p>
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl" style="{{ $stat['iconStyle'] }}"><i class="bi {{ $stat['icon'] }} text-lg"></i></span>
                    </div>
                    <p class="mt-4 text-4xl font-bold tracking-tight text-slate-900">{{ $stat['value'] }}</p>
                    <p class="mt-3 text-sm font-medium text-emerald-500" style="color: #00a870;">{{ $stat['trend'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch mb-6">
            <article class="lg:col-span-2 h-full bg-white rounded-3xl p-6 shadow-sm flex flex-col dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Event Terbaru</h2>
                <div class="mt-6 flex-1 divide-y divide-slate-100">
                    @foreach ($events as $event)
                        <div class="flex items-center gap-4 py-3.5 first:pt-0 last:pb-0">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sm font-bold text-sky-600">{{ $event['initials'] }}</span>
                            <div class="min-w-0 flex-1"><p class="truncate text-base font-bold text-slate-800">{{ $event['name'] }}</p><p class="mt-0.5 text-sm text-slate-400">{{ $event['meta'] }}</p></div>
                            <span class="shrink-0 rounded-full px-3 py-1 text-xs font-medium {{ $event['statusClass'] }}">{{ $event['status'] }}</span>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="lg:col-span-1 h-full bg-sky-500 rounded-3xl p-6 text-white shadow-sm flex flex-col justify-between dashboard-highlight-card">
                <div>
                    <h2 class="text-lg font-bold text-white">Ringkasan Konten</h2>
                    <p class="mt-1 text-sm text-sky-100">Status semua konten CMS</p>
                </div>
                <div class="mt-8 space-y-4">
                    @foreach ($contentSummary as $item)
                        <div><div class="mb-1.5 flex items-center justify-between text-sm text-white"><span>{{ $item['label'] }}</span><strong>{{ $item['value'] }}</strong></div><div class="h-2 overflow-hidden rounded-full bg-sky-600/50"><div class="h-2 rounded-full bg-white" style="width: {{ ($item['value'] / 24) * 100 }}%"></div></div></div>
                    @endforeach
                </div>
                <div class="mt-4 border-t border-sky-400/50 pt-4 text-sm font-medium text-white">Total konten aktif: 84</div>
            </article>
        </section>

        <section class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Sponsor Teratas</h2>
                <div class="mt-5 divide-y divide-slate-100">
                    @foreach ($sponsors as $sponsor)
                        <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0"><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-50 text-sm font-semibold text-sky-600">{{ $loop->iteration }}</span><p class="flex-1 text-base text-slate-600">{{ $sponsor }}</p><span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-600">Platinum</span></div>
                    @endforeach
                </div>
            </article>

            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dashboard-panel-card">
                <h2 class="text-lg font-bold text-slate-800">Aktivitas Terkini</h2>
                <div class="mt-5 divide-y divide-slate-100">
                    @foreach ($activities as $activity)
                        <div class="flex gap-4 py-3.5 first:pt-0 last:pb-0"><span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full {{ $activity['dot'] }}"></span><div><p class="text-base text-slate-600">{{ $activity['label'] }}</p><p class="mt-1 text-sm text-slate-400">{{ $activity['time'] }}</p></div></div>
                    @endforeach
                </div>
            </article>
        </section>
    </div>
</div>
@endsection
