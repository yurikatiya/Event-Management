@extends('layouts.admin')

@section('title', 'Partners')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-4 py-8 sm:px-6 lg:px-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Partners</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $partners->total() }} mitra strategis</p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                    <form method="GET" class="relative w-full sm:w-[280px]">
                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-base text-sky-500"></i>
                        <input name="search" value="{{ request('search') }}" placeholder="Search partners..." class="h-12 w-full rounded-full border border-blue-100 bg-blue-50/70 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </form>
                    <a href="{{ route('admin.partners.create') }}" class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white shadow-[0_8px_20px_rgba(2,132,199,0.2)] transition hover:-translate-y-0.5 hover:bg-sky-700"><i class="bi bi-plus-lg text-base leading-none"></i><span>Add Partner</span></a>
                </div>
            </div>
        </header>
        @php($partnerIcons = ['GEKRAFS Jabar' => 'bi-people', 'Chlorine' => 'bi-droplet', 'Telkom University' => 'bi-building', 'UPI' => 'bi-book', 'R27 Creative Agency' => 'bi-palette', 'Digital Breeze' => 'bi-wind', 'Metalabs' => 'bi-cpu'])
        <section class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            @forelse ($partners as $partner)
                <article class="group rounded-[2rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)] transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_16px_38px_rgba(59,130,246,0.1)] sm:p-7">
                    <div class="flex items-start gap-4">
                        <div class="flex shrink-0 flex-col items-center pt-1"><span class="h-4 w-4 rounded-full border-4 border-sky-100 bg-sky-500 ring-4 ring-white"></span><span class="mt-2 h-8 w-px bg-blue-100"></span></div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-blue-100 bg-blue-50 text-xl text-sky-600">
                                        @if ($partner->logo)<img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }} logo" class="h-full w-full object-contain p-2">@else<i class="bi {{ $partnerIcons[$partner->name] ?? 'bi-building' }}"></i>@endif
                                    </div>
                                    <h2 class="truncate text-lg font-bold text-slate-800" title="{{ $partner->name }}">{{ $partner->name }}</h2>
                                </div>
                                <span class="shrink-0 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">{{ $partner->category }}</span>
                            </div>
                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-blue-100 pt-4">
                                <form method="POST" action="{{ route('admin.partners.toggle-status', $partner) }}">@csrf @method('PATCH')<button class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $partner->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-700' }}">{{ $partner->status === 'published' ? 'Published' : 'Publish' }}</button></form>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.partners.edit', $partner) }}" class="inline-flex h-9 items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 text-xs font-semibold text-blue-700 transition hover:bg-blue-100" title="Edit partner" aria-label="Edit partner"><i class="bi bi-pencil-square text-sm leading-none"></i><span>Edit</span></a>
                                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Hapus partner ini?')">@csrf @method('DELETE')<button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-blue-100 bg-white text-sky-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500" title="Delete partner" aria-label="Delete partner"><i class="bi bi-trash-fill text-sm leading-none"></i></button></form>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[2rem] border border-blue-100 bg-white p-10 shadow-sm xl:col-span-2"><x-admin.empty-state icon="bi-people" title="No partners yet" description="Tambahkan partner pertama Anda." /></div>
            @endforelse
        </section>
        @if ($partners->hasPages()) <div class="mt-6 rounded-[1.75rem] border border-blue-100 bg-white px-6 py-4 shadow-sm">{{ $partners->links() }}</div> @endif
    </div>
</div>
@endsection