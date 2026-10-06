@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="crud-page gallery-album-page px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <header class="gallery-library-header mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="gallery-eyebrow">ARSIP DOKUMENTASI</p>
                    <h1 class="gallery-page-title">Galeri event</h1>
                    <p class="gallery-page-subtitle" data-live-search-summary>
                        @if ($selectedAlbum)
                            {{ $selectedAlbum['photos']->count() }} foto dalam album <span aria-hidden="true">·</span> {{ $photoCount }} foto tersimpan
                        @else
                            {{ $albums->total() }} album <span aria-hidden="true">·</span> {{ $photoCount }} foto tersimpan
                        @endif
                    </p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                    <form method="GET" data-live-search class="gallery-search relative w-full sm:w-[280px]">
                        @if ($selectedAlbum)
                            <input type="hidden" name="album" value="{{ $selectedAlbum['key'] }}">
                        @endif
                        <i class="bi bi-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-base" aria-hidden="true"></i>
                        <input name="search" value="{{ request('search') }}" placeholder="{{ $selectedAlbum ? 'Cari foto di album ini' : 'Cari nama event atau foto' }}" aria-label="{{ $selectedAlbum ? 'Cari foto di album' : 'Cari album galeri' }}" autocomplete="off">
                    </form>
                    <a href="{{ route('admin.gallery.create') }}" class="gallery-primary-button"><i class="bi bi-folder-plus" aria-hidden="true"></i><span>Buat album</span></a>
                </div>
        </header>

        <div data-live-search-results>
        @if ($selectedAlbum)
            <div class="gallery-album-detail">
                <div class="gallery-album-detail-header">
                    <div class="min-w-0">
                        <a class="gallery-back-link" href="{{ route('admin.gallery.index', request()->only('search')) }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> Semua album</a>
                        <div class="gallery-album-heading">
                            <div class="min-w-0">
                                <p class="gallery-album-kicker"><i class="bi bi-folder2-open" aria-hidden="true"></i> ALBUM EVENT</p>
                                <h2>{{ $selectedAlbum['name'] }}</h2>
                            </div>
                            <div class="gallery-album-heading-meta">
                                <span class="gallery-album-count">{{ $selectedAlbum['photos']->count() }} foto</span>
                                <a href="{{ route('admin.gallery.create') }}" class="gallery-add-photo-button" aria-label="Tambah foto" title="Tambah foto">
                                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 5v14M5 12h14" /></svg>
                                </a>
                            </div>
                        </div>
                        @if ($selectedAlbum['event']?->start_date)
                            <p class="gallery-album-date"><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $selectedAlbum['event']->start_date->translatedFormat('d M Y') }}</p>
                        @endif
                    </div>
                </div>

                <section class="gallery-photo-grid" data-gallery-photo-grid aria-label="Foto dalam album {{ $selectedAlbum['name'] }}">
                    @forelse ($selectedAlbum['photos'] as $photo)
                        <article class="gallery-photo-card">
                            <button type="button" class="gallery-photo-open" data-gallery-photo
                                data-src="{{ asset('storage/' . $photo->file_path) }}"
                                data-title="{{ $photo->caption ?: $photo->title ?: 'Foto dokumentasi' }}"
                                data-status="{{ $photo->status === 'published' ? 'Tampil' : 'Draft' }}"
                                data-edit-url="{{ route('admin.gallery.edit', $photo) }}"
                                data-delete-url="{{ route('admin.gallery.destroy', $photo) }}"
                                aria-label="Lihat {{ $photo->caption ?: $photo->title ?: 'foto dokumentasi' }}">
                                <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->caption ?: $photo->title ?: 'Foto dokumentasi ' . $selectedAlbum['name'] }}" loading="lazy">
                                <span class="gallery-photo-zoom"><i class="bi bi-arrows-fullscreen" aria-hidden="true"></i><span>Lihat foto</span></span>
                            </button>
                            <div class="gallery-photo-card-footer">
                                <div class="gallery-photo-copy">
                                    <span>{{ $photo->caption ?: $photo->title ?: 'Foto dokumentasi' }}</span>
                                    <small>{{ $photo->status === 'published' ? 'Tampil' : 'Draft' }}</small>
                                </div>
                                <div class="gallery-photo-actions">
                                    <a href="{{ route('admin.gallery.edit', $photo) }}" title="Edit foto" aria-label="Edit foto {{ $photo->caption ?: $photo->title }}"><i class="bi bi-pencil-square" aria-hidden="true"></i></a>
                                    <form method="POST" action="{{ route('admin.gallery.destroy', $photo) }}" onsubmit="return confirm('Hapus foto ini dari album?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus foto" aria-label="Hapus foto {{ $photo->caption ?: $photo->title }}"><i class="bi bi-trash" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="gallery-album-empty">
                            <span><i class="bi bi-images" aria-hidden="true"></i></span>
                            <h2>{{ request('search') ? 'Foto tidak ditemukan' : 'Album ini belum memiliki foto' }}</h2>
                            <p>{{ request('search') ? 'Coba kata kunci lain untuk mencari foto.' : 'Tambahkan foto dokumentasi ke album ini.' }}</p>
                        </div>
                    @endforelse
                </section>
            </div>
        @else
            <section class="gallery-album-grid">
                @forelse ($albums as $album)
                    <article class="gallery-album-card">
                        <a href="{{ route('admin.gallery.index', array_filter(['album' => $album['key'], 'search' => request('search')])) }}" class="gallery-album-cover" aria-label="Lihat semua foto album {{ $album['name'] }}">
                            @foreach ($album['photos']->take(4) as $photo)
                                <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $photo->caption ?: $photo->title ?: 'Dokumentasi ' . $album['name'] }}" loading="lazy">
                            @endforeach
                            <span class="gallery-album-cover-action"><i class="bi bi-arrow-up-right" aria-hidden="true"></i><span>Buka album</span></span>
                        </a>
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
                            <a class="gallery-album-open-link" href="{{ route('admin.gallery.index', array_filter(['album' => $album['key'], 'search' => request('search')])) }}">Lihat semua foto <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
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
        @endif
        </div>
    </div>
</div>

<div class="gallery-lightbox" data-gallery-lightbox hidden role="dialog" aria-modal="true" aria-label="Pratinjau foto galeri">
    <button type="button" class="gallery-lightbox-close" data-gallery-close aria-label="Tutup">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6 6 18" /></svg>
    </button>
    <button type="button" class="gallery-lightbox-nav gallery-lightbox-prev" data-gallery-prev aria-label="Foto sebelumnya"><i class="bi bi-chevron-left" aria-hidden="true"></i></button>
    <figure class="gallery-lightbox-content">
        <img data-gallery-lightbox-image alt="">
        <figcaption>
            <div><strong data-gallery-lightbox-title></strong><span data-gallery-lightbox-count></span></div>
            <div class="gallery-lightbox-actions">
                <span data-gallery-lightbox-status></span>
                <a data-gallery-lightbox-edit class="gallery-lightbox-button"><i class="bi bi-pencil-square" aria-hidden="true"></i> Edit foto</a>
                <form method="POST" data-gallery-lightbox-delete-form onsubmit="return confirm('Hapus foto ini dari album?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="gallery-lightbox-button gallery-lightbox-delete"><i class="bi bi-trash" aria-hidden="true"></i> Hapus</button>
                </form>
            </div>
        </figcaption>
    </figure>
    <button type="button" class="gallery-lightbox-nav gallery-lightbox-next" data-gallery-next aria-label="Foto berikutnya"><i class="bi bi-chevron-right" aria-hidden="true"></i></button>
</div>

<script>
    const lightbox = document.querySelector('[data-gallery-lightbox]');
    const lightboxImage = lightbox?.querySelector('[data-gallery-lightbox-image]');
    const lightboxTitle = lightbox?.querySelector('[data-gallery-lightbox-title]');
    const lightboxCount = lightbox?.querySelector('[data-gallery-lightbox-count]');
    const lightboxStatus = lightbox?.querySelector('[data-gallery-lightbox-status]');
    const lightboxEdit = lightbox?.querySelector('[data-gallery-lightbox-edit]');
    const lightboxDeleteForm = lightbox?.querySelector('[data-gallery-lightbox-delete-form]');
    let lightboxPhotos = [];
    let lightboxIndex = 0;

    const renderLightboxPhoto = () => {
        const photo = lightboxPhotos[lightboxIndex];
        if (!photo) return;

        lightboxImage.src = photo.dataset.src;
        lightboxImage.alt = photo.dataset.title;
        lightboxTitle.textContent = photo.dataset.title;
        lightboxCount.textContent = `${lightboxIndex + 1} / ${lightboxPhotos.length}`;
        lightboxStatus.textContent = photo.dataset.status;
        lightboxEdit.href = photo.dataset.editUrl;
        lightboxDeleteForm.action = photo.dataset.deleteUrl;
    };

    const closeLightbox = () => {
        lightbox.hidden = true;
        document.body.classList.remove('gallery-lightbox-open');
        lightboxImage.removeAttribute('src');
    };

    document.addEventListener('click', (event) => {
        const photoButton = event.target.closest('[data-gallery-photo]');
        if (photoButton) {
            const photoGrid = photoButton.closest('[data-gallery-photo-grid]');
            lightboxPhotos = Array.from(photoGrid.querySelectorAll('[data-gallery-photo]'));
            lightboxIndex = lightboxPhotos.indexOf(photoButton);
            renderLightboxPhoto();
            lightbox.hidden = false;
            document.body.classList.add('gallery-lightbox-open');
            lightbox.querySelector('[data-gallery-close]').focus();
            return;
        }

        if (event.target.closest('[data-gallery-close]') || event.target === lightbox) closeLightbox();
        if (event.target.closest('[data-gallery-prev]')) {
            lightboxIndex = (lightboxIndex - 1 + lightboxPhotos.length) % lightboxPhotos.length;
            renderLightboxPhoto();
        }
        if (event.target.closest('[data-gallery-next]')) {
            lightboxIndex = (lightboxIndex + 1) % lightboxPhotos.length;
            renderLightboxPhoto();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (lightbox.hidden) return;
        if (event.key === 'Escape') closeLightbox();
        if (event.key === 'ArrowLeft') {
            lightboxIndex = (lightboxIndex - 1 + lightboxPhotos.length) % lightboxPhotos.length;
            renderLightboxPhoto();
        }
        if (event.key === 'ArrowRight') {
            lightboxIndex = (lightboxIndex + 1) % lightboxPhotos.length;
            renderLightboxPhoto();
        }
    });
</script>
@endsection
