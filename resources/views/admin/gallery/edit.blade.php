@extends('layouts.admin')

@section('title', 'Edit Foto')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-3xl">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Edit Foto</h1>
                <p class="mt-1 text-sm text-slate-400">Perbarui judul, deskripsi, status, atau gambar foto.</p>
            </div>

            <form method="POST" action="{{ route('admin.gallery.update', $gallery) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                @if ($gallery->file_path)
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="h-48 w-full rounded-lg object-cover">
                    </div>
                @endif

                <div>
                    <label for="title" class="form-label">Judul foto</label>
                    <input id="title" name="title" value="{{ old('title', $gallery->title) }}" required class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="form-label">Deskripsi / Keterangan</label>
                    <textarea id="description" name="description" rows="4" class="form-input rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="form-label">Ganti gambar</label>
                    <input id="image" type="file" name="image" accept="image/*" class="form-input rounded-xl border-slate-200 p-2 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                    @error('image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" required class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                        <option value="published" @selected(old('status', $gallery->status) === 'published')>Tampil</option>
                        <option value="draft" @selected(old('status', $gallery->status) === 'draft')>Draft</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-600">
                        <i class="bi bi-floppy me-2"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
