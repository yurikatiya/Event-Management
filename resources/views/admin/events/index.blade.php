@extends('layouts.admin')

@section('title', 'Events')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-4 py-8 sm:px-6 lg:px-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Events</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $events->total() }} event terdaftar</p>
                </div>
                <form method="GET" class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                    <div class="relative w-full sm:w-[220px]">
                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-base text-sky-500"></i>
                        <input name="search" value="{{ request('search') }}" placeholder="Search events..." class="h-12 w-full rounded-full border border-blue-100 bg-blue-50/70 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </div>
                    <div class="relative sm:w-[155px]">
                        <select name="category_id" class="h-12 w-full appearance-none rounded-full border border-blue-100 bg-blue-50/70 px-4 pr-9 text-sm text-slate-700 outline-none focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                            <option value="">All categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-sky-500"></i>
                    </div>
                    <div class="relative sm:w-[135px]">
                        <select name="status" class="h-12 w-full appearance-none rounded-full border border-blue-100 bg-blue-50/70 px-4 pr-9 text-sm text-slate-700 outline-none focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                            <option value="">All status</option>
                            @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-sky-500"></i>
                    </div>
                    <button type="submit" class="inline-flex h-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50 px-5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">Filter</button>
                    <a href="{{ route('admin.events.create') }}" class="inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white shadow-[0_8px_20px_rgba(2,132,199,0.2)] transition hover:-translate-y-0.5 hover:bg-sky-700">
                        <i class="bi bi-plus-lg text-base leading-none"></i>
                        <span>Add Event</span>
                    </a>
                </form>
            </div>
        </header>

        <section class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            @forelse ($events as $event)
                @php
                    $statusLabel = match ($event->status) {
                        'published' => 'Published',
                        'archived' => 'Archived',
                        default => 'Draft',
                    };
                    $statusClass = match ($event->status) {
                        'published' => 'bg-emerald-50 text-emerald-600',
                        'archived' => 'bg-slate-100 text-slate-600',
                        default => 'bg-amber-50 text-amber-600',
                    };
                @endphp
                <article class="group rounded-[2rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)] transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_16px_38px_rgba(59,130,246,0.1)] sm:p-7">
                    <div class="flex items-start gap-4">
                        <div class="flex shrink-0 flex-col items-center pt-1">
                            <span class="h-4 w-4 rounded-full border-4 border-sky-100 bg-sky-500 ring-4 ring-white"></span>
                            <span class="mt-2 h-8 w-px bg-blue-100"></span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <h2 class="min-w-0 text-lg font-bold text-slate-800">{{ $event->name }}</h2>
                                <span class="shrink-0 rounded-full border border-blue-100 px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </div>
                            <span class="mt-2 inline-flex rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $event->category?->name ?? 'Uncategorized' }}</span>
                            <div class="mt-4 grid gap-2 rounded-2xl border border-blue-100/80 bg-blue-50/60 px-4 py-3.5 text-sm text-slate-600 sm:grid-cols-2">
                                <p><i class="bi bi-calendar3 me-2 text-sky-500"></i>@if (! $event->start_date)Date not set @elseif ($event->end_date && $event->start_date->year !== $event->end_date->year){{ $event->start_date->year }}-{{ $event->end_date->year }}@else{{ $event->start_date->year }}@endif</p>
                                <p class="truncate"><i class="bi bi-geo-alt me-2 text-sky-500"></i>{{ $event->location }}</p>
                            </div>
                            @if ($event->published_galleries_count > 0)
                                <div class="mt-4 rounded-xl border border-blue-100 bg-white p-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600"><i class="bi bi-images text-sky-600" aria-hidden="true"></i>Dokumentasi</span>
                                        <span class="shrink-0 text-xs font-semibold text-sky-700">{{ $event->published_galleries_count }} foto</span>
                                    </div>
                                    <div class="mt-2 flex items-center gap-2">
                                        @foreach ($event->gallery_previews as $photo)
                                            <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->caption ?: 'Dokumentasi ' . $event->name }}" class="h-14 w-16 shrink-0 rounded-lg border border-blue-50 object-cover" loading="lazy">
                                        @endforeach
                                        @if ($event->published_galleries_count > $event->gallery_previews->count())
                                            <span class="inline-flex h-14 min-w-14 items-center justify-center rounded-lg bg-blue-50 px-2 text-xs font-semibold text-blue-700">+{{ $event->published_galleries_count - $event->gallery_previews->count() }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('admin.gallery.index', ['search' => $event->name]) }}" class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-sky-700 hover:text-sky-900">Lihat album <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                                </div>
                            @endif
                            <div class="mt-5 flex items-center justify-between border-t border-blue-100 pt-4">
                                <span class="text-xs font-medium text-slate-400">Event details</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex h-9 items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 text-xs font-semibold text-blue-700 transition hover:bg-blue-100" title="Edit event" aria-label="Edit event">
                                        <i class="bi bi-pencil-square text-sm leading-none"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-blue-100 bg-white text-sky-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500" title="Hapus event" aria-label="Hapus event">
                                            <i class="bi bi-trash-fill text-sm leading-none"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[2rem] border border-blue-100 bg-white p-10 shadow-sm xl:col-span-2">
                    <x-admin.empty-state icon="bi-calendar-x" title="Belum ada event" description="Tambahkan event pertama Anda untuk memulai." />
                </div>
            @endforelse
        </section>

        @if ($events->hasPages())
            <div class="mt-6">{{ $events->links('admin.events.pagination') }}</div>
        @endif
    </div>
</div>
@endsection