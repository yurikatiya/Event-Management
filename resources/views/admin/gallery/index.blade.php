@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-[1400px]">
        <header class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Gallery</h1>
                <p class="mt-1 text-base text-slate-400">Kelola foto yang akan ditampilkan di landing page.</p>
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-white text-2xl font-light leading-none text-slate-700 shadow-[0_8px_18px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_12px_22px_rgba(15,23,42,0.12)]" style="line-height: 1;" title="Tambah Foto" aria-label="Tambah Foto">
                +
            </a>
        </header>

        @if (session('success'))
            <div class="mb-5"><x-admin.alert>{{ session('success') }}</x-admin.alert></div>
        @endif

        @if (session('error'))
            <div class="mb-5"><x-admin.alert type="error">{{ session('error') }}</x-admin.alert></div>
        @endif

        <section class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($galleries as $gallery)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="h-52 overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                    </div>
                    <div class="space-y-3 p-5">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="truncate text-base font-bold text-slate-800">{{ $gallery->title }}</h2>
                            <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $gallery->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $gallery->status === 'published' ? 'Tampil' : 'Draft' }}
                            </span>
                        </div>
                        <p class="line-clamp-3 text-sm leading-6 text-slate-500">{{ $gallery->description ?: 'Tidak ada keterangan.' }}</p>
                        <div class="flex items-center justify-between border-t border-slate-200 pt-4">
                            <a href="{{ route('admin.gallery.edit', $gallery) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-lg font-light leading-none text-slate-700 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-[0_8px_14px_rgba(15,23,42,0.08)]" style="line-height: 1;" title="Edit Foto" aria-label="Edit Foto">
                                +
                            </a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $gallery) }}" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-medium text-red-500 hover:text-red-600">
                                    <i class="bi bi-trash3-fill"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-10 shadow-sm md:col-span-2 xl:col-span-3">
                    <x-admin.empty-state icon="bi-images" title="Belum ada foto" description="Tambah foto pertama Anda untuk ditampilkan di landing page." />
                </div>
            @endforelse
        </section>

        @if ($galleries->hasPages())
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-6 py-4 shadow-sm">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
