@extends('layouts.admin')

@section('title', 'Sponsors')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-white px-4 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-8 flex items-center justify-between gap-4">
            <div class="shrink-0">
                <h1 class="text-3xl font-bold tracking-tight text-[#16324f]">Sponsors</h1>
                <p class="mt-1 whitespace-nowrap text-base text-slate-400">{{ $sponsors->total() }} sponsor terdaftar</p>
            </div>
            <div class="flex w-full items-center gap-3 sm:w-auto">
                <div class="relative w-full sm:w-[260px]">
                    <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
                    <form method="GET">
                        <input name="search" value="{{ request('search') }}" placeholder="Search sponsors..." class="h-[46px] w-full rounded-full border border-slate-200 bg-slate-50 pl-11 pr-4 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </form>
                </div>
                <a href="{{ route('admin.sponsors.create') }}" class="inline-flex h-[46px] w-[46px] shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-lg text-slate-700 shadow-[0_8px_18px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_22px_rgba(15,23,42,0.12)]" title="Tambah Sponsor" aria-label="Tambah Sponsor"><i class="bi bi-plus leading-none"></i></a>
            </div>
        </header>

        <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($sponsors as $sponsor)
                <article class="rounded-2xl border border-[#dceaf7] bg-white px-5 py-6 text-center shadow-sm">
                    <div class="mx-auto flex h-[70px] w-[70px] items-center justify-center overflow-hidden rounded-[20px] bg-[#eff7ff] text-3xl text-slate-500">
                        @if ($sponsor->logo)
                            <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }} logo" class="h-full w-full object-contain p-2">
                        @else
                            <i class="bi bi-award"></i>
                        @endif
                    </div>
                    <h2 class="mt-5 truncate text-base font-bold text-[#16324f]" title="{{ $sponsor->name }}">{{ $sponsor->name }}</h2>
                    <p class="mt-1 truncate text-sm text-slate-400">{{ $sponsor->tier ?? 'General' }}</p>
                    <div class="mt-5 flex items-center justify-center gap-3">
                        <a href="{{ route('admin.sponsors.edit', $sponsor) }}" title="Edit sponsor" aria-label="Edit sponsor" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-sky-50 text-sky-600 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-sky-100"><i class="bi bi-pencil-square text-base leading-none"></i></a>
                        <form method="POST" action="{{ route('admin.sponsors.destroy', $sponsor) }}" onsubmit="return confirm('Hapus sponsor ini?')">@csrf @method('DELETE')<button title="Delete sponsor" aria-label="Delete sponsor" class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100"><i class="bi bi-trash-fill"></i></button></form>
                    </div>
                    <form method="POST" action="{{ route('admin.sponsors.toggle-status', $sponsor) }}" class="mt-3">@csrf @method('PATCH')<button class="text-xs font-semibold {{ in_array($sponsor->status, ['published', 'active']) ? 'text-emerald-500' : 'text-sky-600' }}">{{ in_array($sponsor->status, ['published', 'active']) ? 'Active' : 'Activate' }}</button></form>
                </article>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-10 xl:col-span-4"><x-admin.empty-state icon="bi-award" title="No sponsors yet" description="Tambahkan sponsor pertama Anda." /></div>
            @endforelse
        </section>

        @if ($sponsors->hasPages())
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-6 py-4">{{ $sponsors->links() }}</div>
        @endif
    </div>
</div>
@endsection
