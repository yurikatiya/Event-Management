<div class="crud-page min-h-[calc(100vh-4rem)] bg-blue-50/50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-[1100px]">
        <div class="crud-form-intro mb-6 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            <a href="{{ route('admin.events.index') }}" class="crud-back-link inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Events</span>
            </a>
            <p class="crud-form-eyebrow mt-6 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
            <h1 class="crud-form-title mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="crud-form-subtitle mt-2 text-sm text-slate-500">{{ $subtitle }}</p>
        </div>

        @if ($errors->any())
            <div class="crud-error-summary mb-6 rounded-[1.75rem] border border-rose-100 bg-rose-50 p-5 text-sm text-rose-600">
                <p class="font-semibold">Please check the form below.</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="crud-form-panel rounded-[2.5rem] border border-blue-100 bg-white p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
            @csrf
            @if ($method !== 'POST') @method($method) @endif

            <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,1.35fr)_minmax(300px,0.85fr)]">
                <section class="space-y-6">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Event Title</label>
                        <input id="name" name="name" value="{{ old('name', $event?->name) }}" placeholder="Enter event title" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                        @error('name') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                        <textarea id="description" name="description" rows="6" placeholder="Describe the event agenda, highlights, etc..." required class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">{{ old('description', $event?->description) }}</textarea>
                        @error('description') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="mb-2 block text-sm font-semibold text-slate-700">Date</label>
                            <div class="relative">
                                <button type="button" class="absolute left-3 top-1/2 z-10 flex h-7 w-7 -translate-y-1/2 items-center justify-center text-sky-500" aria-label="Pilih tanggal" onclick="document.getElementById('start_date').showPicker?.()">
                                    <i class="bi bi-calendar3 text-lg" aria-hidden="true"></i>
                                </button>
                                <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $event?->start_date?->format('Y-m-d')) }}" class="date-input h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 pr-4 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100" style="padding-left: 3rem;">
                            </div>
                            @error('start_date') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Location</label>
                            <div class="relative">
                                <i class="bi bi-geo-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sky-500"></i>
                                <input id="location" name="location" value="{{ old('location', $event?->location) }}" placeholder="Enter event location" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100" style="padding-left: 3rem;">
                            </div>
                            @error('location') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">Category</label>
                            <div class="relative">
                                <select id="category_id" name="category_id" required class="h-12 w-full appearance-none rounded-2xl border border-blue-100 bg-blue-50/50 px-4 pr-10 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $event?->category_id) == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-sky-500"></i>
                            </div>
                            @error('category_id') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sponsor_ids" class="mb-2 block text-sm font-semibold text-slate-700">Sponsor Multi-Select</label>
                            <div class="relative">
                                <select id="sponsor_ids" name="sponsor_ids[]" multiple size="1" class="h-12 w-full appearance-none rounded-2xl border border-blue-100 bg-blue-50/50 px-4 py-2 pr-10 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                                    @foreach ($sponsors as $sponsor)
                                        <option value="{{ $sponsor->id }}" @selected(in_array($sponsor->id, old('sponsor_ids', $event?->sponsors?->pluck('id')->all() ?? [])))>{{ $sponsor->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-sky-500"></i>
                            </div>
                        </div>
                    </div>

                </section>

                <aside class="space-y-6">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Cover Image</label>
                        <label for="poster" class="group relative flex min-h-[240px] cursor-pointer items-center justify-center overflow-hidden rounded-[2rem] border-2 border-dashed border-blue-200 bg-blue-50/60 p-4 text-center transition hover:border-sky-300 hover:bg-blue-50">
                            @if ($event?->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }} banner" class="absolute inset-0 h-full w-full object-cover opacity-80">
                            @else
                                <div class="absolute inset-0 bg-blue-50/60"></div>
                            @endif
                            <span class="relative flex flex-col items-center gap-3 rounded-2xl border border-blue-100 bg-white px-5 py-4 text-sm font-semibold text-blue-700 shadow-sm">
                                <i class="bi bi-upload text-2xl text-sky-600"></i>
                                <span>{{ $event?->poster ? 'Change Cover' : 'Add Cover' }}</span>
                            </span>
                            <input id="poster" type="file" name="poster" accept="image/*" class="sr-only">
                        </label>
                        <p class="mt-2 text-xs text-slate-400">PNG, JPG up to 2MB. Cover wajib untuk event baru.</p>
                        @error('poster') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                        <div class="relative">
                            <select id="status" name="status" required class="h-12 w-full appearance-none rounded-2xl border border-blue-100 bg-blue-50/50 px-4 pr-10 text-sm text-slate-700 outline-none transition focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
                                @foreach (['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $event?->status ?? 'draft') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-sky-500"></i>
                        </div>
                        @error('status') <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </aside>
            </div>

            <div class="crud-form-actions mt-8 flex flex-col-reverse gap-3 border-t border-blue-100 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.events.index') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-blue-100 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-blue-50">Cancel</a>
                <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white transition hover:bg-sky-700"><i class="bi bi-check-lg"></i>Save Event</button>
            </div>
        </form>
    </div>
</div>
