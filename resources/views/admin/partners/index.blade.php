@extends('layouts.admin')

@section('title', 'Partners')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-[#f1f8ff] px-4 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-8 flex items-center justify-between gap-4">
            <div><h1 class="text-3xl font-bold tracking-tight text-[#16324f]">Partners</h1><p class="mt-1 text-base text-slate-400">{{ $partners->total() }} mitra strategis</p></div>
            <a href="{{ route('admin.partners.create') }}" class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-2xl font-light leading-none text-slate-700 shadow-[0_8px_18px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_22px_rgba(15,23,42,0.12)]" style="line-height: 1;" title="Tambah Partner" aria-label="Tambah Partner">+</a>
        </header>
        <form method="GET" class="mb-6 max-w-sm"><div class="relative"><i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i><input name="search" value="{{ request('search') }}" placeholder="Search partners..." class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-11 pr-4 text-sm outline-none focus:border-sky-400"></div></form>
        @php($partnerIcons = ['GEKRAFS Jabar' => 'bi-people', 'Chlorine' => 'bi-droplet', 'Telkom University' => 'bi-building', 'UPI' => 'bi-book', 'R27 Creative Agency' => 'bi-palette', 'Digital Breeze' => 'bi-wind', 'Metalabs' => 'bi-cpu'])
        <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($partners as $partner)
                <article class="rounded-2xl border border-[#dceaf7] bg-white px-5 py-6 text-center shadow-sm">
                    <div class="mx-auto flex h-[70px] w-[70px] items-center justify-center overflow-hidden rounded-[20px] bg-[#eff7ff] text-3xl text-slate-500">
                        @if ($partner->logo)<img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }} logo" class="h-full w-full object-contain p-2">@else<i class="bi {{ $partnerIcons[$partner->name] ?? 'bi-building' }}"></i>@endif
                    </div>
                    <h2 class="mt-5 truncate text-base font-bold text-[#16324f]" title="{{ $partner->name }}">{{ $partner->name }}</h2>
                    <p class="mt-1 truncate text-sm text-slate-400">{{ $partner->category }}</p>
                    <div class="mt-5 flex items-center justify-center gap-3">
                        <a href="{{ route('admin.partners.edit', $partner) }}" title="Edit partner" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-lg font-light leading-none text-slate-700 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_8px_14px_rgba(15,23,42,0.08)]" style="line-height: 1;">+</a>
                        <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Hapus partner ini?')">@csrf @method('DELETE')<button title="Delete partner" class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100"><i class="bi bi-trash3"></i></button></form>
                    </div>
                    <form method="POST" action="{{ route('admin.partners.toggle-status', $partner) }}" class="mt-3">@csrf @method('PATCH')<button class="text-xs font-semibold {{ $partner->status === 'published' ? 'text-emerald-500' : 'text-sky-600' }}">{{ $partner->status === 'published' ? 'Published' : 'Publish' }}</button></form>
                </article>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-10 xl:col-span-4"><x-admin.empty-state icon="bi-people" title="No partners yet" description="Tambahkan partner pertama Anda." /></div>
            @endforelse
        </section>
        @if ($partners->hasPages()) <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-6 py-4">{{ $partners->links() }}</div> @endif
    </div>
</div>
@endsection