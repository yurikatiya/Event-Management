@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-4 py-8 sm:px-6 lg:px-8" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Gallery</h1>
                    <p class="mt-2 text-sm text-slate-500">{{ $galleries->total() }} foto terdaftar</p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                    <form method="GET" class="relative w-full sm:w-[280px]">
                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-base text-sky-500"></i>
                        <input name="search" value="{{ request('search') }}" placeholder="Search gallery..." class="h-12 w-full rounded-full border border-blue-100 bg-blue-50/70 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    </form>
                    <a href="{{ route('admin.gallery.create') }}" class="inline-flex h-12 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white shadow-[0_8px_20px_rgba(2,132,199,0.2)] transition hover:-translate-y-0.5 hover:bg-sky-700"><i class="bi bi-plus-lg text-base leading-none"></i><span>Add Photo</span></a>
                </div>
            </div>
        </header>

        <section class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            @forelse ($galleries as $gallery)
                <article class="group overflow-hidden rounded-[2rem] border border-blue-100 bg-white shadow-[0_10px_32px_rgba(59,130,246,0.055)] transition duration-200 hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-[0_16px_38px_rgba(59,130,246,0.1)]">
                    <div class="h-56 overflow-hidden bg-blue-50">
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                    </div>
                    <div class="space-y-3 p-5 sm:p-7">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="truncate text-base font-bold text-slate-800">{{ $gallery->title }}</h2>
                            <span class="shrink-0 rounded-full border border-blue-100 px-3 py-1.5 text-xs font-semibold {{ $gallery->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $gallery->status === 'published' ? 'Tampil' : 'Draft' }}
                            </span>
                        </div>
                        <p class="line-clamp-3 rounded-2xl border border-blue-100/80 bg-blue-50/60 px-4 py-3.5 text-sm leading-6 text-slate-600">{{ $gallery->description ?: 'Tidak ada keterangan.' }}</p>
                        <div class="flex items-center justify-between border-t border-blue-100 pt-4">
                            <span class="text-xs font-medium text-slate-400">Gallery details</span>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.gallery.edit', $gallery) }}" class="inline-flex h-9 items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 text-xs font-semibold text-blue-700 transition hover:bg-blue-100" title="Edit Foto" aria-label="Edit Foto">
                                    <i class="bi bi-pencil-square text-sm leading-none"></i><span>Edit</span>
                            </a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $gallery) }}" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-blue-100 bg-white text-sky-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-500" title="Delete Foto" aria-label="Delete Foto">
                                    <i class="bi bi-trash-fill text-base leading-none"></i>
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[2rem] border border-blue-100 bg-white p-10 shadow-sm xl:col-span-2">
                    <x-admin.empty-state icon="bi-images" title="Belum ada foto" description="Tambah foto pertama Anda ke galeri admin." />
                </div>
            @endforelse
        </section>

        @if ($galleries->hasPages())
            <div class="mt-6 rounded-[1.75rem] border border-blue-100 bg-white px-6 py-4 shadow-sm">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
