<div class="crud-page min-h-[calc(100vh-4rem)] bg-blue-50/50 px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[900px]">
        <div class="crud-form-intro mb-6 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <a href="{{ route('admin.teams.index') }}" class="crud-back-link inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"><i class="bi bi-arrow-left"></i><span>Back to Teams</span></a>
            <p class="crud-form-eyebrow mt-6 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
            <h1 class="crud-form-title mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="crud-form-subtitle mt-2 text-sm text-slate-500">{{ $team ? 'Perbarui informasi anggota team.' : 'Tambahkan anggota team baru.' }}</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="crud-error-summary mx-auto mb-6 max-w-[900px] rounded-[1.75rem] border border-rose-100 bg-rose-50 p-5 text-sm text-rose-600">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="crud-form-panel mx-auto max-w-[900px] rounded-[2.5rem] border border-blue-100 bg-white p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
        @csrf
        @if ($method !== 'POST') @method($method) @endif

        <div class="space-y-6">
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>
                <input id="name" name="name" value="{{ old('name', $team?->name) }}" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
            </div>
            <div>
                <label for="position" class="mb-2 block text-sm font-semibold text-slate-700">Position</label>
                <input id="position" name="position" value="{{ old('position', $team?->position) }}" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
            </div>
            <div>
                <label for="division" class="mb-2 block text-sm font-semibold text-slate-700">Division</label>
                <input id="division" name="division" value="{{ old('division', $team?->division) }}" placeholder="Contoh: Creative, Design, Operations" class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
            </div>
            <div>
                <label for="photo" class="mb-2 block text-sm font-semibold text-slate-700">Photo</label>
                @if ($team?->photo)
                    <img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}" class="mb-3 h-24 w-24 rounded-full border-4 border-blue-50 object-cover">
                @endif
                <input id="photo" type="file" name="photo" accept="image/*" class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-sky-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-sky-700">
                @error('photo') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="bio" class="mb-2 block text-sm font-semibold text-slate-700">Bio</label>
                <textarea id="bio" name="bio" rows="5" class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">{{ old('bio', $team?->bio) }}</textarea>
            </div>
            <div>
                <label for="order" class="mb-2 block text-sm font-semibold text-slate-700">Order</label>
                <input id="order" type="number" name="order" min="1" value="{{ old('order', $team?->order ?? 1) }}" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
            </div>
            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                <select id="status" name="status" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    <option value="draft" @selected(old('status', $team?->status ?? 'draft') === 'draft')>Draft / Nonaktif</option>
                    <option value="published" @selected(old('status', $team?->status) === 'published')>Published / Aktif</option>
                    <option value="archived" @selected(old('status', $team?->status) === 'archived')>Archived</option>
                </select>
            </div>
        </div>

        <div class="crud-form-actions mt-8 flex flex-col-reverse gap-3 border-t border-blue-100 pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.teams.index') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-blue-100 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-blue-50">Cancel</a>
            <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white transition hover:bg-sky-700"><i class="bi bi-check-lg"></i>Save</button>
        </div>
    </form>
</div>
