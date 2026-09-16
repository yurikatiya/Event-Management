<div class="mx-auto max-w-[900px] p-5 sm:p-8">
    <div class="mb-6">
        <a href="{{ route('admin.sponsors.index') }}" class="text-sm font-semibold text-sky-600"><i class="bi bi-arrow-left me-2"></i>Back to Sponsors</a>
        <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ $title }}</h1>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-rose-50 p-4 text-sm text-rose-600">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="space-y-5">
            <div>
                <label for="name" class="form-label">Sponsor Name</label>
                <input id="name" name="name" value="{{ old('name', $sponsor?->name) }}" required class="form-input">
                @error('name')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="tier" class="form-label">Tier</label>
                    <select id="tier" name="tier" required class="form-input">
                        @foreach (['Platinum', 'Gold', 'Silver', 'Bronze'] as $tier)
                            <option value="{{ $tier }}" @selected(old('tier', $sponsor?->tier) === $tier)>{{ $tier }}</option>
                        @endforeach
                    </select>
                    @error('tier')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" required class="form-input">
                        @foreach (['draft' => 'Draft', 'active' => 'Active', 'archived' => 'Archived'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $sponsor?->status ?? 'draft') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $sponsor?->email) }}" class="form-input">
                    @error('email')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="form-label">Phone</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $sponsor?->phone) }}" class="form-input">
                    @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="logo" class="form-label">Logo</label>
                @if ($sponsor?->logo)
                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }} logo" class="mb-3 h-20 w-20 rounded-xl object-contain">
                @endif
                <input id="logo" type="file" name="logo" accept="image/*" class="form-input">
                @error('logo')<p class="form-error">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="5" class="form-input">{{ old('description', $sponsor?->description) }}</textarea>
                @error('description')<p class="form-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
            <a href="{{ route('admin.sponsors.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600">Cancel</a>
            <button type="submit" class="rounded-xl bg-sky-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-600"><i class="bi bi-check-lg me-2"></i>Save Sponsor</button>
        </div>
    </form>
</div>
