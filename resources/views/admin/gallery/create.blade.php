@extends('layouts.admin')

@section('title', $preselectedEvent ? 'Tambah Foto Galeri' : 'Buat Album Galeri')

@section('content')
@php
    $selectedEvent = $events->firstWhere('id', old('event_id', $preselectedEvent?->id));
    $isAddingToAlbum = $preselectedEvent !== null;
@endphp
<div class="crud-page gallery-album-page px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-5xl">
        <header class="gallery-library-header mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <a href="{{ $isAddingToAlbum ? route('admin.gallery.index', ['album' => 'event-' . $preselectedEvent->id]) : route('admin.gallery.index') }}" class="crud-back-link mb-5 inline-flex items-center gap-2"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>{{ $isAddingToAlbum ? 'Kembali ke album' : 'Kembali ke galeri' }}</span></a>
                <p class="gallery-eyebrow">DOKUMENTASI EVENT</p>
                <h1 class="gallery-page-title">{{ $isAddingToAlbum ? 'Tambah foto' : 'Buat album' }}</h1>
                <p class="gallery-page-subtitle">
                    {{ $isAddingToAlbum ? 'Foto baru akan langsung ditambahkan ke album ' . $preselectedEvent->name . '.' : 'Pilih event, lalu tambahkan semua foto dokumentasinya.' }}
                </p>
            </div>
            <span class="gallery-upload-limit"><i class="bi bi-images" aria-hidden="true"></i> Maks. 15 foto sekali upload</span>
        </header>

        @php($imageErrors = $errors->get('images.*'))
        @if ($errors->has('images') || $imageErrors !== [])
            <div class="gallery-upload-alerts" data-gallery-alerts>
                <div class="gallery-upload-alert" data-gallery-alert role="alert">
                    <i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i>
                    <div><strong>Upload gagal</strong><span>{{ $errors->first('images') ?: $errors->first('images.*') }}</span></div>
                    <button type="button" data-gallery-alert-close aria-label="Tutup notifikasi"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
                </div>
            </div>
        @else
            <div class="gallery-upload-alerts" data-gallery-alerts></div>
        @endif

        @if ($errors->any())
            <div class="crud-error-summary mb-5" role="alert">
                <p class="font-semibold">Periksa kembali data foto.</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="crud-form-panel gallery-album-form" data-gallery-album-form>
            @csrf

            <section class="gallery-form-section">
                <div class="gallery-section-heading">
                    <span class="gallery-section-number">01</span>
                    <div>
                        <h2>{{ $isAddingToAlbum ? 'Album tujuan' : 'Masukkan ke event' }}</h2>
                        <p>{{ $isAddingToAlbum ? 'Foto tambahan akan masuk ke album event ini.' : 'Foto akan dikumpulkan dalam folder dokumentasi event yang dipilih.' }}</p>
                    </div>
                </div>
                <div class="gallery-form-field">
                    @if ($isAddingToAlbum)
                        <span class="gallery-fixed-event-label">Event</span>
                        <div class="gallery-fixed-event">
                            <span class="gallery-fixed-event-icon"><i class="bi bi-calendar-event" aria-hidden="true"></i></span>
                            <span>
                                <strong>{{ $preselectedEvent->name }}</strong>
                                <small>{{ $preselectedEvent->start_date?->format('d M Y') ?? 'Tanggal belum ditentukan' }}</small>
                            </span>
                        </div>
                        <input type="hidden" name="event_id" value="{{ $preselectedEvent->id }}" data-event-value>
                    @else
                        <label for="event_id">Event</label>
                        <div class="gallery-event-picker" data-event-picker>
                            <input type="hidden" name="event_id" value="{{ old('event_id') }}" data-event-value>
                            <button type="button" id="event_id" class="gallery-event-trigger" role="combobox" aria-haspopup="listbox" aria-expanded="false" aria-controls="gallery-event-options" aria-label="Pilih event" data-event-trigger>
                                <span class="gallery-event-selected">
                                    <strong data-event-name>{{ $selectedEvent?->name ?? 'Pilih event' }}</strong>
                                    <small data-event-date @if (! $selectedEvent) hidden @endif>{{ $selectedEvent?->start_date?->format('d M Y') }}</small>
                                </span>
                                <i class="bi bi-chevron-down" aria-hidden="true"></i>
                            </button>
                            <div class="gallery-event-menu" data-event-menu hidden>
                                <label class="gallery-event-search">
                                    <i class="bi bi-search" aria-hidden="true"></i>
                                    <input id="gallery-event-search-input" type="search" placeholder="Cari nama event..." autocomplete="off" aria-label="Cari event" data-event-search>
                                </label>
                                <div class="gallery-event-options" id="gallery-event-options" role="listbox" aria-label="Daftar event" data-event-options>
                            @foreach ($events as $event)
                                        <button type="button" class="gallery-event-option" role="option" data-event-option data-value="{{ $event->id }}" data-name="{{ $event->name }}" data-date="{{ $event->start_date?->format('d M Y') }}" data-search="{{ strtolower($event->name . ' ' . ($event->start_date?->format('d M Y') ?? '')) }}" aria-selected="{{ (string) old('event_id') === (string) $event->id ? 'true' : 'false' }}">
                                            <span><strong>{{ $event->name }}</strong><small>{{ $event->start_date?->format('d M Y') ?? 'Tanggal belum ditentukan' }}</small></span>
                                            <i class="bi bi-check2" aria-hidden="true"></i>
                                        </button>
                            @endforeach
                                    <p class="gallery-event-empty" data-event-empty role="status" hidden>Event tidak ditemukan.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($events->isEmpty())
                        <p class="gallery-form-note">Belum ada event. <a href="{{ route('admin.events.create') }}">Buat event terlebih dahulu.</a></p>
                    @endif
                    @error('event_id')<p class="gallery-field-error" data-event-error>{{ $message }}</p>@else<p class="gallery-field-error" data-event-error hidden>Pilih salah satu event.</p>@enderror
                </div>
            </section>

            <section class="gallery-form-section">
                <div class="gallery-section-heading">
                    <span class="gallery-section-number">02</span>
                    <div>
                        <h2>Foto dokumentasi</h2>
                        <p>Pilih beberapa foto sekaligus. Setiap foto maksimal 2 MB.</p>
                    </div>
                </div>
                <label class="gallery-multi-dropzone" data-gallery-dropzone>
                    <input class="gallery-multi-input" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple required data-gallery-files>
                    <span class="gallery-drop-icon"><i class="bi bi-cloud-arrow-up" aria-hidden="true"></i></span>
                    <span class="gallery-drop-title">Pilih foto atau tarik ke sini</span>
                    <span class="gallery-drop-hint">JPG, PNG, atau WebP · maksimal 15 foto</span>
                    <span class="gallery-drop-action"><i class="bi bi-plus-lg" aria-hidden="true"></i> Pilih foto</span>
                </label>
                @error('images')<p class="gallery-field-error">{{ $message }}</p>@enderror
                @error('images.*')<p class="gallery-field-error">{{ $message }}</p>@enderror
                <div class="gallery-selected-files" data-gallery-preview aria-live="polite" hidden></div>
            </section>

            <section class="gallery-form-section gallery-form-grid">
                <div class="gallery-form-field">
                    <label for="description">{{ $isAddingToAlbum ? 'Keterangan foto' : 'Keterangan album' }} <span>(opsional)</span></label>
                    <textarea id="description" name="description" rows="4" maxlength="1000" placeholder="Tambahkan cerita singkat tentang dokumentasi event ini...">{{ old('description') }}</textarea>
                    @error('description')<p class="gallery-field-error">{{ $message }}</p>@enderror
                </div>
                <fieldset class="gallery-form-field">
                    <legend>{{ $isAddingToAlbum ? 'Status foto' : 'Status album' }}</legend>
                    <div class="gallery-status-options">
                        <label class="gallery-status-choice">
                            <input type="radio" name="status" value="published" @checked(old('status', 'published') === 'published') required>
                            <span class="gallery-status-dot"></span>
                            <span><strong>Tampil</strong><small>{{ $isAddingToAlbum ? 'Foto langsung terlihat di album' : 'Dapat dilihat di galeri' }}</small></span>
                        </label>
                        <label class="gallery-status-choice">
                            <input type="radio" name="status" value="draft" @checked(old('status') === 'draft') required>
                            <span class="gallery-status-dot"></span>
                            <span><strong>Draft</strong><small>{{ $isAddingToAlbum ? 'Simpan foto tanpa ditampilkan' : 'Simpan sebagai konsep' }}</small></span>
                        </label>
                    </div>
                    @error('status')<p class="gallery-field-error">{{ $message }}</p>@enderror
                </fieldset>
            </section>

            <footer class="gallery-form-footer">
                <a href="{{ $isAddingToAlbum ? route('admin.gallery.index', ['album' => 'event-' . $preselectedEvent->id]) : route('admin.gallery.index') }}" class="gallery-secondary-button">Batal</a>
                <button type="submit" class="gallery-primary-button" @disabled($events->isEmpty())><i class="bi {{ $isAddingToAlbum ? 'bi-plus-lg' : 'bi-folder-plus' }}" aria-hidden="true"></i><span>{{ $isAddingToAlbum ? 'Tambah foto' : 'Buat album' }}</span></button>
            </footer>
        </form>
    </div>
</div>

<script>
    const albumForm = document.querySelector('[data-gallery-album-form]');
    const galleryFiles = albumForm?.querySelector('[data-gallery-files]');
    const galleryDropzone = albumForm?.querySelector('[data-gallery-dropzone]');
    const galleryPreview = albumForm?.querySelector('[data-gallery-preview]');
    const eventPicker = albumForm?.querySelector('[data-event-picker]');
    const eventValue = eventPicker?.querySelector('[data-event-value]');
    const eventTrigger = eventPicker?.querySelector('[data-event-trigger]');
    const eventName = eventPicker?.querySelector('[data-event-name]');
    const eventDate = eventPicker?.querySelector('[data-event-date]');
    const eventMenu = eventPicker?.querySelector('[data-event-menu]');
    const eventSearch = eventPicker?.querySelector('[data-event-search]');
    const eventOptions = Array.from(eventPicker?.querySelectorAll('[data-event-option]') ?? []);
    const eventEmpty = eventPicker?.querySelector('[data-event-empty]');
    const eventError = albumForm?.querySelector('[data-event-error]');

    const closeEventPicker = () => {
        eventMenu.hidden = true;
        eventTrigger.setAttribute('aria-expanded', 'false');
    };

    const filterEventOptions = () => {
        const query = eventSearch.value.trim().toLocaleLowerCase();
        let visibleCount = 0;

        eventOptions.forEach((option) => {
            option.hidden = !option.dataset.search.includes(query);
            if (!option.hidden) visibleCount += 1;
        });

        eventEmpty.hidden = visibleCount > 0;
    };

    const openEventPicker = () => {
        eventMenu.hidden = false;
        eventTrigger.setAttribute('aria-expanded', 'true');
        eventSearch.value = '';
        filterEventOptions();
        eventSearch.focus();
    };

    eventTrigger?.addEventListener('click', () => {
        if (eventMenu.hidden) openEventPicker();
        else closeEventPicker();
    });

    eventSearch?.addEventListener('input', filterEventOptions);
    eventSearch?.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            event.preventDefault();
            const visibleOptions = eventOptions.filter((option) => !option.hidden);
            (event.key === 'ArrowDown' ? visibleOptions[0] : visibleOptions.at(-1))?.focus();
        } else if (event.key === 'Escape') {
            closeEventPicker();
            eventTrigger.focus();
        } else if (event.key === 'Enter') {
            const firstOption = eventOptions.find((option) => !option.hidden);
            if (firstOption) {
                event.preventDefault();
                firstOption.click();
            }
        }
    });

    eventPicker?.querySelector('[data-event-options]')?.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeEventPicker();
            eventTrigger.focus();
            return;
        }

        if (event.key !== 'ArrowDown' && event.key !== 'ArrowUp') return;

        const visibleOptions = eventOptions.filter((option) => !option.hidden);
        const currentIndex = visibleOptions.indexOf(event.target.closest('[data-event-option]'));
        const nextIndex = event.key === 'ArrowDown'
            ? Math.min(currentIndex + 1, visibleOptions.length - 1)
            : Math.max(currentIndex - 1, 0);

        event.preventDefault();
        visibleOptions[nextIndex]?.focus();
    });

    eventOptions.forEach((option) => {
        option.addEventListener('click', () => {
            eventValue.value = option.dataset.value;
            eventName.textContent = option.dataset.name;
            eventDate.textContent = option.dataset.date || 'Tanggal belum ditentukan';
            eventDate.hidden = !option.dataset.date;
            eventOptions.forEach((item) => item.setAttribute('aria-selected', String(item === option)));
            eventPicker.classList.remove('is-invalid');
            eventTrigger.setAttribute('aria-invalid', 'false');
            eventError.hidden = true;
            closeEventPicker();
            eventTrigger.focus();
        });
    });

    document.addEventListener('click', (event) => {
        if (eventPicker && !eventPicker.contains(event.target)) closeEventPicker();
    });

    albumForm?.addEventListener('submit', (event) => {
        if (eventValue.value) return;

        event.preventDefault();
        eventPicker.classList.add('is-invalid');
        eventTrigger.setAttribute('aria-invalid', 'true');
        eventError.hidden = false;
        openEventPicker();
    });

    const galleryAlertContainer = document.querySelector('[data-gallery-alerts]');
    const maxImageSize = 2 * 1024 * 1024;

    const dismissGalleryAlert = (alert) => {
        alert.classList.add('is-closing');
        window.setTimeout(() => alert.remove(), 180);
    };

    const showGalleryAlert = (message) => {
        const alert = document.createElement('div');
        alert.className = 'gallery-upload-alert';
        alert.setAttribute('role', 'alert');
        alert.innerHTML = '<i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i><div><strong>Upload gagal</strong><span></span></div><button type="button" aria-label="Tutup notifikasi"><i class="bi bi-x-lg" aria-hidden="true"></i></button>';
        alert.querySelector('span').textContent = message;
        alert.querySelector('button').addEventListener('click', () => dismissGalleryAlert(alert));
        galleryAlertContainer.append(alert);
        window.setTimeout(() => {
            if (alert.isConnected) dismissGalleryAlert(alert);
        }, 6000);
    };

    galleryAlertContainer?.querySelectorAll('[data-gallery-alert]').forEach((alert) => {
        alert.querySelector('[data-gallery-alert-close]')?.addEventListener('click', () => dismissGalleryAlert(alert));
        window.setTimeout(() => {
            if (alert.isConnected) dismissGalleryAlert(alert);
        }, 6000);
    });

    const renderGalleryFiles = (incomingFiles = Array.from(galleryFiles?.files ?? [])) => {
        const tooLarge = incomingFiles.filter((file) => file.size > maxImageSize);
        const exceededLimit = incomingFiles.length > 15;
        const validFiles = incomingFiles.filter((file) => file.size <= maxImageSize).slice(0, 15);
        const transfer = new DataTransfer();
        validFiles.forEach((file) => transfer.items.add(file));
        galleryFiles.files = transfer.files;
        const files = Array.from(transfer.files);

        if (tooLarge.length) {
            const names = tooLarge.map((file) => file.name).join(', ');
            showGalleryAlert(`${names} melebihi batas 2 MB per foto. File tersebut tidak disertakan.`);
        }
        if (exceededLimit) showGalleryAlert('Maksimal 15 foto dapat diunggah dalam satu album.');

        galleryPreview.querySelectorAll('[data-object-url]').forEach((item) => URL.revokeObjectURL(item.dataset.objectUrl));
        galleryPreview.replaceChildren();
        galleryPreview.hidden = files.length === 0;

        if (files.length === 0) return;

        const heading = document.createElement('p');
        heading.className = 'gallery-selected-heading';
        heading.textContent = `${files.length} foto dipilih`;
        galleryPreview.append(heading);

        const list = document.createElement('ul');
        list.className = 'gallery-selected-list';
        files.forEach((file) => {
            const item = document.createElement('li');
            const preview = document.createElement('img');
            preview.className = 'gallery-selected-thumbnail';
            preview.alt = '';
            item.dataset.objectUrl = URL.createObjectURL(file);
            preview.src = item.dataset.objectUrl;
            const name = document.createElement('span');
            name.textContent = file.name;
            item.append(preview, name);
            list.append(item);
        });
        galleryPreview.append(list);
    };

    galleryFiles?.addEventListener('change', () => renderGalleryFiles());
    galleryDropzone?.addEventListener('dragover', (event) => {
        event.preventDefault();
        galleryDropzone.classList.add('is-dragging');
    });
    galleryDropzone?.addEventListener('dragleave', (event) => {
        if (!galleryDropzone.contains(event.relatedTarget)) galleryDropzone.classList.remove('is-dragging');
    });
    galleryDropzone?.addEventListener('drop', (event) => {
        event.preventDefault();
        galleryDropzone.classList.remove('is-dragging');
        renderGalleryFiles([...(galleryFiles.files ?? []), ...event.dataTransfer.files]);
    });
</script>
@endsection