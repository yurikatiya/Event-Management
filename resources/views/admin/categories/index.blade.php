@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
@php
    $categoryColors = [
        ['dot' => 'bg-sky-600', 'badge' => 'bg-slate-50 text-slate-600'],
        ['dot' => 'bg-amber-500', 'badge' => 'bg-slate-50 text-slate-600'],
        ['dot' => 'bg-emerald-500', 'badge' => 'bg-slate-50 text-slate-600'],
        ['dot' => 'bg-blue-500', 'badge' => 'bg-slate-50 text-slate-600'],
        ['dot' => 'bg-red-500', 'badge' => 'bg-slate-50 text-slate-600'],
        ['dot' => 'bg-violet-500', 'badge' => 'bg-slate-50 text-slate-600'],
    ];
@endphp

<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative w-full sm:w-[318px]">
                <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
                <form method="GET">
                    <input name="search" value="{{ request('search') }}" placeholder="Search categories..." class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                </form>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex h-11 w-11 shrink-0 items-center justify-center self-end rounded-full border border-slate-200 bg-white text-2xl font-light leading-none text-slate-700 shadow-[0_8px_18px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_22px_rgba(15,23,42,0.12)] sm:self-auto" style="line-height: 1;" title="Add Category" aria-label="Add Category">
                +
            </a>
        </header>

        @if (session('success'))
            <div class="mb-5"><x-admin.alert>{{ session('success') }}</x-admin.alert></div>
        @endif
        @if (session('error'))
            <div class="mb-5"><x-admin.alert type="error">{{ session('error') }}</x-admin.alert></div>
        @endif

        <section class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            @forelse ($categories as $category)
                @php($color = $categoryColors[$loop->index % count($categoryColors)])
                <article class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <h2 class="flex min-w-0 items-center gap-2 text-lg font-bold text-slate-800">
                            <span class="h-3.5 w-3.5 shrink-0 rounded-full {{ $color['dot'] }}"></span>
                            <span class="truncate">{{ $category->name }}</span>
                        </h2>
                        <span class="shrink-0 rounded-lg px-3 py-1.5 text-xs font-semibold {{ $color['badge'] }}">{{ $category->events_count }} Events</span>
                    </div>
                    <p class="mt-7 min-h-6 text-base leading-6 text-slate-500">{{ $category->description ?: 'No description available.' }}</p>
                    <div class="mt-6 flex items-center justify-between border-t border-slate-200 pt-5">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-lg font-light leading-none text-slate-700 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_8px_14px_rgba(15,23,42,0.08)]" style="line-height: 1;" title="Edit Category" aria-label="Edit Category">
                            +
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-medium text-red-500 hover:text-red-600">
                                <i class="bi bi-trash3-fill text-base"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-10 shadow-sm lg:col-span-2">
                    <x-admin.empty-state icon="bi-tags" title="No categories yet" description="Add a category to organize your events." />
                </div>
            @endforelse
        </section>

        @if ($categories->hasPages())
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-6 py-4 shadow-sm">{{ $categories->links() }}</div>
        @endif
    </div>
</div>
@endsection
