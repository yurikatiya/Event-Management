@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="crud-page gallery-album-page px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <header class="gallery-library-header mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="gallery-eyebrow">ARSIP DOKUMENTASI</p>
                    <h1 class="gallery-page-title">Galeri event</h1>
                    <p class="gallery-page-subtitle">{{ $albums->total() }} album <span aria-hidden="true">·</span> {{ $photoCount }} foto tersimpan</p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                    <form method="GET" class="gallery-search relative w-full sm:w-[280px]">
                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-base" aria-hidden="true"></i>
                        <input name="search" value="{{ request('search') }}" placeholder="Cari nama event atau foto" aria-label="Cari album galeri">
                    </form>
                    <a href="{{ route('admin.gallery.create') }}" class="gallery-primary-button"><i class="bi bi-folder-plus" aria-hidden="true"></i><span>Buat album</span></a>
                </div>
        </header>

        <section class="gallery-album-grid">
            @forelse ($albums as $album)
                <article class="gallery-album-card">
                    <div class="gallery-album-cover" aria-label="Pratinjau {{ $album['name'] }}">
                        @foreach ($album['photos']->take(4) as $photo)
                            <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->caption ?: $photo->title ?: 'Dokumentasi ' . $album['name'] }}" loading="lazy">
                        @endforeach
                    </div>
                    <div class="gallery-album-body">
                        <div class="gallery-album-heading">
                            <div class="min-w-0">
                                <p class="gallery-album-kicker"><i class="bi bi-folder2-open" aria-hidden="true"></i> ALBUM EVENT</p>
                                <h2>{{ $album['name'] }}</h2>
                            </div>
                            <span class="gallery-album-count">{{ $album['photos']->count() }} foto</span>
                        </div>
                        @if ($album['event']?->start_date)
                            <p class="gallery-album-date"><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $album['event']->start_date->translatedFormat('d M Y') }}</p>
                        @endif
                        <details class="gallery-album-details">
                            <summary><span>Lihat isi album</span><i class="bi bi-chevron-down" aria-hidden="true"></i></summary>
                            <div class="gallery-photo-list">
                                @foreach ($album['photos'] as $photo)
                                    <div class="gallery-photo-row">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" alt="" loading="lazy">
                                        <div class="gallery-photo-copy">
                                            <span>{{ $photo->caption ?: $photo->title ?: 'Foto dokumentasi' }}</span>
                                            <small>{{ $photo->status === 'published' ? 'Tampil' : 'Draft' }}</small>
                                        </div>
                                        <a href="{{ route('admin.gallery.edit', $photo) }}" title="Edit foto" aria-label="Edit foto {{ $photo->caption ?: $photo->title }}"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>
                                        <form method="POST" action="{{ route('admin.gallery.destroy', $photo) }}" onsubmit="return confirm('Hapus foto ini dari album?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus foto" aria-label="Hapus foto {{ $photo->caption ?: $photo->title }}"><i class="bi bi-trash" aria-hidden="true"></i></button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                </article>
            @empty
                <div class="gallery-album-empty">
                    <span><i class="bi bi-images" aria-hidden="true"></i></span>
                    <h2>Belum ada album dokumentasi</h2>
                    <p>Pilih event dan unggah foto-foto dokumentasinya sekaligus.</p>
                    <a href="{{ route('admin.gallery.create') }}" class="gallery-primary-button"><i class="bi bi-folder-plus" aria-hidden="true"></i> Buat album pertama</a>
                </div>
            @endforelse
        </section>

        @if ($albums->hasPages())
            <div class="mt-6 rounded-[1.75rem] border border-blue-100 bg-white px-6 py-4 shadow-sm">
                {{ $albums->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
