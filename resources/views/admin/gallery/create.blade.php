@extends('layouts.admin')

@section('title', 'Tambah Foto')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-[900px]">
        <div class="mb-6 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"><i class="bi bi-arrow-left"></i><span>Back to Gallery</span></a>
            <p class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Tambah Foto</h1>
            <p class="mt-2 text-sm text-slate-500">Upload gambar baru untuk galeri admin.</p>
        </div>

        <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="space-y-6 rounded-[2.5rem] border border-blue-100 bg-white p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
                @csrf

                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul foto</label>
                    <input id="title" name="title" value="{{ old('title') }}" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    @error('title')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi / Keterangan</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">Upload gambar</label>
                    <input id="image" type="file" name="image" accept="image/*" required class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-sky-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-sky-700">
                    @error('image')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                    <select id="status" name="status" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                        <option value="published" @selected(old('status') === 'published')>Tampil</option>
                        <option value="draft" @selected(old('status') === 'draft' || ! old('status'))>Draft</option>
                    </select>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-blue-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.gallery.index') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-blue-100 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-blue-50">Batal</a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white transition hover:bg-sky-700">
                        <i class="bi bi-check-circle"></i><span>Simpan Foto</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
