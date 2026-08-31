@extends('layouts.admin')

@section('title', 'Services')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Services</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola layanan dan produk INCO.</p>
            </div>
            <a href="{{ route('admin.services.create') }}" class="inline-flex h-11 w-11 items-center justify-center self-end rounded-full border border-slate-200 bg-white text-2xl font-light leading-none text-slate-700 shadow-[0_8px_18px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_22px_rgba(15,23,42,0.12)] sm:self-auto" style="line-height: 1;" title="Add Service" aria-label="Add Service">+</a>
        </header>

        @if (session('success')) <div class="mb-5"><x-admin.alert>{{ session('success') }}</x-admin.alert></div> @endif
        <form method="GET" class="mb-6 max-w-[360px]">
            <div class="relative"><i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input name="search" value="{{ request('search') }}" placeholder="Search services..." class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm outline-none focus:border-sky-400"></div>
        </form>

        @php
            $serviceIcons = [
                'Creative Agency' => 'bi-palette2',
                'Venue Activation' => 'bi-building',
                'City Branding' => 'bi-geo-alt',
                'Event Planner & Consultant' => 'bi-calendar2-check',
                'Event Organizer' => 'bi-calendar-event',
                'Design & Digital Agency' => 'bi-brush',
            ];
        @endphp
        <section class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($services as $service)
                <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex gap-4">
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-sky-50 text-2xl text-sky-500">
                            @if ($service->image)<img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-full w-full object-cover">@else<i class="bi {{ $serviceIcons[$service->name] ?? 'bi-stars' }}"></i>@endif
                        </div>
                        <div class="min-w-0 flex-1"><div class="flex items-start justify-between gap-3"><h2 class="truncate text-lg font-bold text-slate-800">{{ $service->name }}</h2><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $service->status === 'published' ? 'bg-emerald-50 text-emerald-600' : ($service->status === 'archived' ? 'bg-slate-100 text-slate-600' : 'bg-amber-50 text-amber-600') }}">{{ ucfirst($service->status) }}</span></div><p class="mt-2 text-sm leading-6 text-slate-500">{{ $service->description }}</p></div>
                    </div>
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
                        <form method="POST" action="{{ route('admin.services.toggle-status', $service) }}">@csrf @method('PATCH')<button class="text-sm font-semibold text-sky-600 hover:text-sky-700">{{ $service->status === 'published' ? 'Unpublish' : 'Publish' }}</button></form>
                        <div class="flex items-center gap-4"><a href="{{ route('admin.services.edit', $service) }}" class="text-sm font-medium text-slate-600 hover:text-sky-600"><i class="bi bi-pencil-square me-1"></i>Edit</a><form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus service ini?')">@csrf @method('DELETE')<button class="text-sm font-medium text-red-500 hover:text-red-600"><i class="bi bi-trash3 me-1"></i>Delete</button></form></div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-10 lg:col-span-2"><x-admin.empty-state icon="bi-stars" title="No services yet" description="Tambahkan layanan INCO pertama Anda." /></div>
            @endforelse
        </section>
        @if ($services->hasPages()) <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-6 py-4">{{ $services->links() }}</div> @endif
    </div>
</div>
@endsection