<div class="mx-auto max-w-[900px] p-5 sm:p-8">
    <div class="mb-6">
        <a href="{{ route('admin.teams.index') }}" class="text-sm font-semibold text-sky-600"><i class="bi bi-arrow-left me-2"></i>Back to Teams</a>
        <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $title }}</h1>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-rose-50 p-4 text-sm text-rose-600">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @if ($method !== 'POST') @method($method) @endif

        <div class="space-y-5">
            <div>
                <label for="name" class="form-label">Name</label>
                <input id="name" name="name" value="{{ old('name', $team?->name) }}" required class="form-input">
            </div>
            <div>
                <label for="position" class="form-label">Position</label>
                <input id="position" name="position" value="{{ old('position', $team?->position) }}" required class="form-input">
            </div>
            <div>
                <label for="division" class="form-label">Division</label>
                <input id="division" name="division" value="{{ old('division', $team?->division) }}" placeholder="Contoh: Creative, Design, Operations" class="form-input">
            </div>
            <div>
                <label for="photo" class="form-label">Photo</label>
                @if ($team?->photo)
                    <img src="{{ asset('storage/' . $team->photo) }}" alt="{{ $team->name }}" class="mb-3 h-24 w-24 rounded-full object-cover">
                @endif
                <input id="photo" type="file" name="photo" accept="image/*" class="form-input">
                @error('photo') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="bio" class="form-label">Bio</label>
                <textarea id="bio" name="bio" rows="5" class="form-input">{{ old('bio', $team?->bio) }}</textarea>
            </div>
            <div>
                <label for="order" class="form-label">Order</label>
                <input id="order" type="number" name="order" min="1" value="{{ old('order', $team?->order ?? 1) }}" required class="form-input">
            </div>
            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" required class="form-input">
                    <option value="draft" @selected(old('status', $team?->status ?? 'draft') === 'draft')>Draft / Nonaktif</option>
                    <option value="published" @selected(old('status', $team?->status) === 'published')>Published / Aktif</option>
                    <option value="archived" @selected(old('status', $team?->status) === 'archived')>Archived</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.teams.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600">Cancel</a>
            <button class="rounded-xl bg-sky-500 px-4 py-2.5 text-sm font-semibold text-white">Save</button>
        </div>
    </form>
</div>
