@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
@php
    $categoryColors = [
        ['dot' => 'bg-sky-500', 'badge' => 'bg-sky-50 text-sky-700'],
        ['dot' => 'bg-blue-500', 'badge' => 'bg-blue-50 text-blue-700'],
        ['dot' => 'bg-cyan-500', 'badge' => 'bg-cyan-50 text-cyan-700'],
        ['dot' => 'bg-sky-400', 'badge' => 'bg-sky-50 text-sky-700'],
        ['dot' => 'bg-blue-400', 'badge' => 'bg-blue-50 text-blue-700'],
        ['dot' => 'bg-cyan-400', 'badge' => 'bg-cyan-50 text-cyan-700'],
    ];
@endphp

<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-4 py-8 sm:px-6 lg:px-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Categories</h1>
                    <p data-live-search-summary class="mt-2 text-sm text-slate-500">{{ $categories->total() }} kategori terdaftar</p>
            </div>
                <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                    <form method="GET" data-live-search class="relative w-full sm:w-[280px]">
                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-base text-sky-500"></i>
                        <input name="search" value="{{ request('search') }}" placeholder="Search categories..." autocomplete="off" class="h-12 w-full rounded-full border border-blue-100 bg-blue-50/70 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </form>
                    <a href="{{ route('admin.categories.create') }}" class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white shadow-[0_8px_20px_rgba(2,132,199,0.2)] transition hover:-translate-y-0.5 hover:bg-sky-700">
                        <i class="bi bi-plus-lg text-base leading-none"></i>
                        <span>Add Category</span>
                    </a>
                </div>
            </div>
        </header>

        <div data-live-search-results>
        <section class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            @forelse ($categories as $category)
                @php($color = $categoryColors[$loop->index % count($categoryColors)])
                <article class="group rounded-[2rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)] transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_16px_38px_rgba(59,130,246,0.1)] sm:p-7">
                    <div class="flex items-start gap-4">
                        <div class="flex shrink-0 flex-col items-center pt-1">
                            <span class="h-4 w-4 rounded-full border-4 border-sky-100 {{ $color['dot'] }} ring-4 ring-white"></span>
                            <span class="mt-2 h-8 w-px bg-blue-100"></span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <h2 class="min-w-0 truncate text-lg font-bold text-slate-800">{{ $category->name }}</h2>
                                <span class="shrink-0 rounded-full border border-blue-100 px-3 py-1.5 text-xs font-semibold {{ $color['badge'] }}">{{ $category->events_count }} Events</span>
                            </div>
                            <div class="mt-4 rounded-2xl border border-blue-100/80 bg-blue-50/60 px-4 py-3.5">
                                <p class="text-sm leading-6 text-slate-600">{{ $category->description ?: 'No description available.' }}</p>
                            </div>
                            <div class="mt-5 flex items-center justify-between border-t border-blue-100 pt-4">
                                <span class="text-xs font-medium text-slate-400">Category details</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex h-9 items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 text-xs font-semibold text-blue-700 transition hover:bg-blue-100" title="Edit Category" aria-label="Edit Category">
                                        <i class="bi bi-pencil-square text-sm leading-none"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-blue-100 bg-white text-sky-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500" title="Delete Category" aria-label="Delete Category">
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
                    <x-admin.empty-state icon="bi-tags" title="No categories yet" description="Add a category to organize your events." />
                </div>
            @endforelse
        </section>

        @if ($categories->hasPages())
            <div class="mt-6 rounded-[1.75rem] border border-blue-100 bg-white px-6 py-4 shadow-sm">{{ $categories->links() }}</div>
        @endif
        </div>
    </div>
</div>
@endsection
