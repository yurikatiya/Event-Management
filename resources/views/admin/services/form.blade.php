<div class="mx-auto max-w-[900px] p-5 sm:p-8">
    <div class="mb-6"><a href="{{ route('admin.services.index') }}" class="text-sm font-semibold text-sky-600"><i class="bi bi-arrow-left me-2"></i>Back to Services</a><h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $title }}</h1></div>
    @if ($errors->any()) <div class="mb-5 rounded-xl bg-rose-50 p-4 text-sm text-rose-600">{{ $errors->first() }}</div> @endif
    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf @if ($method !== 'POST') @method($method) @endif
        <div class="space-y-5">
            <div><label for="name" class="form-label">Service Name</label><input id="name" name="name" value="{{ old('name', $service?->name) }}" required class="form-input">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label for="description" class="form-label">Description</label><textarea id="description" name="description" rows="6" required class="form-input">{{ old('description', $service?->description) }}</textarea>@error('description')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label for="image" class="form-label">Icon/Image</label>@if ($service?->image)<img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="mb-3 h-24 w-24 rounded-xl object-cover">@endif<input id="image" type="file" name="image" accept="image/*" class="form-input">@error('image')<p class="form-error">{{ $message }}</p>@enderror</div>
            <div><label for="status" class="form-label">Status</label><select id="status" name="status" required class="form-input"><option value="draft" @selected(old('status', $service?->status ?? 'draft') === 'draft')>Draft</option><option value="published" @selected(old('status', $service?->status) === 'published')>Published</option><option value="archived" @selected(old('status', $service?->status) === 'archived')>Archived</option></select></div>
        </div>
        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5"><a href="{{ route('admin.services.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600">Cancel</a><button class="rounded-xl bg-sky-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-600"><i class="bi bi-check-lg me-2"></i>Save Service</button></div>
    </form>
</div>