@extends('layouts.admin')

@section('title', 'Events')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Events</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola semua event dan jadwal kegiatan</p>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-6">
                <x-admin.alert>{{ session('success') }}</x-admin.alert>
            </div>
        @endif

        <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-4">
            <form method="GET" class="flex flex-col gap-3 md:flex-row md:items-center">
                <div class="relative flex-1">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400"></i>
                    <input name="search" value="{{ request('search') }}" placeholder="Search events..." class="h-12 w-full rounded-xl border border-gray-200 bg-white pl-11 pr-3 text-base text-gray-700 outline-none transition focus:border-sky-400">
                </div>
                <div class="relative md:w-44">
                    <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-600"></i>
                    <select name="category_id" class="h-12 w-full appearance-none rounded-xl border border-gray-200 bg-white px-4 pr-10 text-base text-slate-600 outline-none transition focus:border-sky-400">
                        <option value="">Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative md:w-44">
                    <i class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400"></i>
                    <select name="status" class="h-12 w-full appearance-none rounded-xl border border-gray-200 bg-white px-4 pr-10 text-base text-slate-600 outline-none transition focus:border-sky-400">
                        <option value="">Status</option>
                        @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.events.create') }}" class="inline-flex h-12 shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-sky-500 px-4 text-sm font-medium text-white shadow-sm hover:bg-sky-600">
                    <i class="bi bi-plus text-lg leading-none" aria-hidden="true"></i>
                    <span>Tambah Event</span>
                </a>
            </form>
        </div>

        <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left">
                    <thead class="border-b border-gray-100 bg-gray-50/80">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            <th class="px-6 py-4">Nama Event</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($events as $event)
                            @php
                                $statusLabel = match ($event->status) {
                                    'published' => 'Published',
                                    'archived' => 'Archived',
                                    default => 'Draft',
                                };
                                $statusClass = match ($event->status) {
                                    'published' => 'bg-emerald-50 text-emerald-600',
                                    'archived' => 'bg-slate-50 text-slate-600',
                                    default => 'bg-amber-50 text-amber-600',
                                };
                            @endphp
                            <tr class="transition hover:bg-sky-50/30">
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold text-gray-900">{{ $event->name }}</p>
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $event->category?->name ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm text-gray-600">
                                    @if (! $event->start_date)
                                        -
                                    @elseif ($event->end_date && $event->start_date->year !== $event->end_date->year)
                                        {{ $event->start_date->year }}-{{ $event->end_date->year }}
                                    @else
                                        {{ $event->start_date->year }}
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-sm text-gray-600">{{ $event->location }}</td>
                                <td class="px-6 py-5"><span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.events.edit', $event) }}" title="Edit event" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 p-2 text-sky-600 hover:bg-sky-100">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus event" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 p-2 text-rose-600 hover:bg-rose-100">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"><x-admin.empty-state icon="bi-calendar-x" title="Belum ada event" description="Tambahkan event pertama Anda untuk memulai." /></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($events->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">{{ $events->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
