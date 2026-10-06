<div class="crud-page min-h-[calc(100vh-4rem)] bg-blue-50/50 px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[900px]">
        <div class="crud-form-intro mb-6 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <a href="{{ route('admin.partners.index') }}" class="crud-back-link inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"><i class="bi bi-arrow-left"></i><span>Back to Partners</span></a>
            <p class="crud-form-eyebrow mt-6 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
            <h1 class="crud-form-title mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="crud-form-subtitle mt-2 text-sm text-slate-500">{{ $partner ? 'Perbarui informasi partner.' : 'Tambahkan partner baru.' }}</p>
        </div>
    </div>
    @if ($errors->any()) <div class="crud-error-summary mx-auto mb-6 max-w-[900px] rounded-[1.75rem] border border-rose-100 bg-rose-50 p-5 text-sm text-rose-600">{{ $errors->first() }}</div> @endif
    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="crud-form-panel mx-auto max-w-[900px] rounded-[2.5rem] border border-blue-100 bg-white p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
        @csrf
        @if ($method !== 'POST') @method($method) @endif
        <div class="space-y-6">
            <div>
                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Partner Name</label>
                <input id="name" name="name" value="{{ old('name', $partner?->name) }}" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                @error('name')<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div data-image-upload>
                <label for="logo" class="mb-2 block text-sm font-semibold text-slate-700">Logo</label>
                <img @if ($partner?->logo) src="{{ asset('storage/' . $partner->logo) }}" @endif alt="{{ $partner?->name ?? 'Pratinjau logo partner' }}" data-image-preview-target @if (! $partner?->logo) hidden @endif class="mb-3 h-20 w-20 rounded-2xl border border-blue-100 bg-blue-50 p-2 object-contain">
                <input id="logo" type="file" name="logo" accept="image/*" data-image-preview class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-sky-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-sky-700">
                @error('logo')<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                <textarea id="description" name="description" rows="5" class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">{{ old('description', $partner?->description) }}</textarea>
            </div>
            <div>
                <label for="website" class="mb-2 block text-sm font-semibold text-slate-700">Website</label>
                <input id="website" type="url" name="website" value="{{ old('website', $partner?->website) }}" placeholder="https://example.com" class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                @error('website')<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category" class="mb-2 block text-sm font-semibold text-slate-700">Category</label>
                <select id="category" name="category" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    @foreach (['Government', 'Education', 'Community', 'Company', 'Creative Industry'] as $category)<option value="{{ $category }}" @selected(old('category', $partner?->category) === $category)>{{ $category }}</option>@endforeach
                </select>
            </div>
            <div>
                <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                <select id="status" name="status" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                    @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $partner?->status ?? 'draft') === $value)>{{ $label }}</option>@endforeach
                </select>
            </div>
        </div>
        <div class="crud-form-actions mt-8 flex flex-col-reverse gap-3 border-t border-blue-100 pt-5 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.partners.index') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-blue-100 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-blue-50">Cancel</a>
            <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white transition hover:bg-sky-700"><i class="bi bi-check-lg"></i>Save Partner</button>
        </div>
    </form>
</div>