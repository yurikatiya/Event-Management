@extends('layouts.admin')

@section('title', 'Teams')

@section('content')
@php
    $divisionStyles = [
        'Creative' => ['badge' => 'bg-sky-50 text-sky-700', 'stat' => 'bg-sky-50 text-sky-700'],
        'Design' => ['badge' => 'bg-blue-50 text-blue-700', 'stat' => 'bg-blue-50 text-blue-700'],
        'Operations' => ['badge' => 'bg-cyan-50 text-cyan-700', 'stat' => 'bg-cyan-50 text-cyan-700'],
        'Marketing' => ['badge' => 'bg-sky-50 text-sky-700', 'stat' => 'bg-sky-50 text-sky-700'],
        'Technology' => ['badge' => 'bg-blue-50 text-blue-700', 'stat' => 'bg-blue-50 text-blue-700'],
    ];
    $fallbackStyles = ['bg-slate-50 text-slate-600', 'bg-cyan-50 text-cyan-700', 'bg-blue-50 text-blue-700'];
    $activeTotal = $divisionStats->sum('active');
    $divisionTotal = $divisionStats->count();
@endphp

<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-4 py-8 sm:px-6 lg:px-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Teams</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $teams->total() }} anggota terdaftar</p>
                </div>
                <a href="{{ route('admin.teams.create') }}" class="inline-flex h-12 items-center justify-center gap-2 self-start rounded-full bg-sky-600 px-5 text-sm font-semibold text-white shadow-[0_8px_20px_rgba(2,132,199,0.2)] transition hover:-translate-y-0.5 hover:bg-sky-700 sm:self-auto" title="Tambah Team"><i class="bi bi-plus-lg text-base leading-none"></i><span>Add Team</span></a>
            </div>
        </header>

        <section class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <article class="rounded-[1.75rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)]">
                <span class="inline-flex rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-blue-700">Total Teams</span>
                <strong class="mt-1 block text-2xl text-slate-900">{{ $teams->total() }}</strong>
                <span class="text-[10px] text-slate-400">seluruh anggota team</span>
            </article>
            <article class="rounded-[1.75rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)]">
                <span class="inline-flex rounded-full border border-blue-100 bg-sky-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-sky-700">Anggota Aktif</span>
                <strong class="mt-1 block text-2xl text-slate-900">{{ $activeTotal }}</strong>
                <span class="text-[10px] text-slate-400">status aktif</span>
            </article>
            <article class="rounded-[1.75rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)]">
                <span class="inline-flex rounded-full border border-blue-100 bg-cyan-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-cyan-700">Divisi</span>
                <strong class="mt-1 block text-2xl text-slate-900">{{ $divisionTotal }}</strong>
                <span class="text-[10px] text-slate-400">divisi terdaftar</span>
            </article>
        </section>

        <section class="overflow-hidden rounded-[2rem] border border-blue-100 bg-white shadow-[0_10px_32px_rgba(59,130,246,0.055)]">
            <div class="flex flex-col gap-3 border-b border-blue-100 bg-blue-50/40 p-4 sm:flex-row sm:items-center">
                <form method="GET" class="relative flex-1">
                    @if (request('division')) <input type="hidden" name="division" value="{{ request('division') }}"> @endif
                    @if (request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                    <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                    <input name="search" value="{{ request('search') }}" placeholder="Cari anggota tim..." class="h-11 w-full rounded-full border border-blue-100 bg-white pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:ring-4 focus:ring-sky-100">
                </form>
                <form method="GET" class="flex items-center gap-2">
                    <select name="division" onchange="this.form.submit()" class="h-11 rounded-full border border-blue-100 bg-white px-4 text-sm text-slate-600 outline-none focus:border-sky-300 focus:ring-4 focus:ring-sky-100">
                        <option value="">Semua Divisi</option>
                        @foreach ($divisions as $division)<option value="{{ $division }}" @selected(request('division') === $division)>{{ $division }}</option>@endforeach
                    </select>
                    <select name="status" onchange="this.form.submit()" class="h-11 rounded-full border border-blue-100 bg-white px-4 text-sm text-slate-600 outline-none focus:border-sky-300 focus:ring-4 focus:ring-sky-100">
                        <option value="">Semua Status</option>
                        <option value="published" @selected(request('status') === 'published')>Aktif</option>
                        <option value="draft" @selected(request('status') === 'draft')>Nonaktif</option>
                        <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                    </select>
                </form>
                <div class="flex items-center justify-between gap-3 sm:ml-auto">
                    <span class="text-[10px] text-slate-400">{{ $activeTotal }} anggota</span>
                    <div class="flex rounded-full border border-blue-100 bg-white p-1 text-xs font-semibold">
                        <button type="button" data-team-view="table" class="team-view-button rounded-full px-3 py-1.5 text-slate-500" aria-label="Tampilan tabel"><i class="bi bi-list-ul me-1"></i>Tabel</button>
                        <button type="button" data-team-view="grid" class="team-view-button rounded-full px-3 py-1.5 text-slate-500" aria-label="Tampilan grid"><i class="bi bi-grid-3x3-gap me-1"></i>Grid</button>
                    </div>
                </div>
            </div>

            <div data-team-table class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">
                    <thead class="border-b border-blue-100 bg-blue-50/60 text-[10px] font-bold uppercase tracking-wide text-blue-700">
                        <tr><th class="px-4 py-3">Anggota</th><th class="px-4 py-3">Jabatan</th><th class="px-4 py-3">Divisi</th><th class="px-4 py-3">Email</th><th class="px-4 py-3">Status</th><th class="px-4 py-3 text-right">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($teams as $team)
                            @php($style = $divisionStyles[$team->division] ?? ['badge' => 'bg-slate-50 text-slate-600'])
                            <tr class="text-xs text-slate-600 transition hover:bg-blue-50/60">
                                <td class="px-4 py-3"><div class="flex items-center gap-3"><div class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-sky-50 text-sky-500">@if ($team->photo)<img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}" class="h-full w-full object-cover">@else<i class="bi bi-person-fill"></i>@endif</div><strong class="text-slate-800">{{ $team->name }}</strong></div></td>
                                <td class="px-4 py-3">{{ $team->position }}</td><td class="px-4 py-3"><span class="rounded-md px-2 py-1 text-[10px] font-medium {{ $style['badge'] }}">{{ $team->division ?: 'Belum diisi' }}</span></td><td class="px-4 py-3">{{ strtolower(str_replace(' ', '', $team->name)) }}@r27.id</td>
                                <td class="px-4 py-3"><span class="rounded-full px-2 py-1 text-[10px] font-semibold {{ $team->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-500' }}"><i class="bi bi-circle-fill me-1 text-[6px]"></i>{{ $team->status === 'published' ? 'Aktif' : 'Nonaktif' }}</span></td>
                                <td class="px-4 py-3"><div class="flex justify-end gap-2"><a href="{{ route('admin.teams.edit', $team) }}" class="text-slate-400 hover:text-sky-600" title="Edit"><i class="bi bi-pencil-square"></i></a><form method="POST" action="{{ route('admin.teams.destroy', $team) }}" onsubmit="return confirm('Hapus anggota team ini?')">@csrf @method('DELETE')<button class="text-slate-400 hover:text-rose-500" title="Hapus"><i class="bi bi-trash-fill"></i></button></form></div></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-slate-400">Belum ada anggota team.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div data-team-grid class="hidden grid-cols-1 gap-5 bg-blue-50/40 p-4 sm:grid-cols-2 xl:grid-cols-2">
                @forelse ($teams as $team)
                    @php($style = $divisionStyles[$team->division] ?? ['badge' => 'bg-slate-50 text-slate-600'])
                    <article class="flex min-h-[285px] flex-col rounded-[2rem] border border-blue-100 bg-white p-5 shadow-[0_10px_32px_rgba(59,130,246,0.055)] transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_16px_38px_rgba(59,130,246,0.1)]"><div class="flex justify-center"><div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-full bg-blue-50 text-2xl text-sky-500 ring-4 ring-blue-50">@if ($team->photo)<img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}" class="h-full w-full object-cover">@else<i class="bi bi-person-fill"></i>@endif</div></div><h3 class="mt-3 text-center text-sm font-bold text-slate-900">{{ $team->name }}</h3><p class="text-center text-xs text-slate-500">{{ $team->position }}</p><div class="mt-3 flex items-center justify-between"><span class="rounded-full border border-blue-100 px-3 py-1 text-[10px] font-semibold {{ $style['badge'] }}">{{ $team->division ?: 'Belum diisi' }}</span><span class="rounded-full px-2 py-1 text-[9px] font-semibold {{ $team->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-500' }}"><i class="bi bi-circle-fill me-1 text-[5px]"></i>{{ $team->status === 'published' ? 'Aktif' : 'Nonaktif' }}</span></div><p class="mt-3 truncate text-[10px] text-slate-400">{{ strtolower(str_replace(' ', '', $team->name)) }}@r27.id</p><div class="mt-auto flex gap-2 border-t border-blue-100 pt-4"><a href="{{ route('admin.teams.edit', $team) }}" class="flex-1 rounded-full border border-blue-100 bg-blue-50 py-2 text-center text-xs font-semibold text-blue-700 transition hover:bg-blue-100">Edit</a><form method="POST" action="{{ route('admin.teams.destroy', $team) }}" class="flex-1" onsubmit="return confirm('Hapus anggota team ini?')">@csrf @method('DELETE')<button class="w-full rounded-full border border-blue-100 py-2 text-xs font-semibold text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">Hapus</button></form></div></article>
                @empty
                    <div class="col-span-full p-8 text-center text-sm text-slate-400">Belum ada anggota team.</div>
                @endforelse
            </div>

            @if ($teams->hasPages())<div class="border-t border-blue-100 px-6 py-4 text-xs">{{ $teams->links() }}</div>@endif
        </section>
    </div>
</div>

@push('scripts')
<script>
    const teamViewButtons = document.querySelectorAll('[data-team-view]');
    const teamTable = document.querySelector('[data-team-table]');
    const teamGrid = document.querySelector('[data-team-grid]');
    const setTeamView = (view) => {
        const isGrid = view === 'grid';
        teamTable?.classList.toggle('hidden', isGrid);
        teamGrid?.classList.toggle('hidden', !isGrid);
        teamGrid?.classList.toggle('grid', isGrid);
        teamViewButtons.forEach((button) => {
            const active = button.dataset.teamView === view;
            button.classList.toggle('bg-[#12a6ea]', active);
            button.classList.toggle('text-white', active);
            button.classList.toggle('text-slate-500', !active);
        });
        localStorage.setItem('teams-view', view);
    };
    teamViewButtons.forEach((button) => button.addEventListener('click', () => setTeamView(button.dataset.teamView)));
    setTeamView(localStorage.getItem('teams-view') || 'table');
</script>
@endpush
@endsection
