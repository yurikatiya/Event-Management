<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-[1400px]">
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-400" aria-label="Breadcrumb">
            <a href="{{ route('admin.events.index') }}" class="font-medium text-sky-600 hover:text-sky-700">Events</a>
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-slate-500">{{ $title }}</span>
        </nav>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-100 bg-rose-50 p-4 text-sm text-rose-600">
                <p class="font-semibold">Please check the form below.</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            @csrf
            @if ($method !== 'POST') @method($method) @endif

            <div class="grid items-start gap-10 p-6 sm:p-8 lg:grid-cols-[minmax(0,1.55fr)_minmax(360px,0.85fr)]">
                <section class="space-y-6">
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Event Title</label>
                        <input id="name" name="name" value="{{ old('name', $event?->name) }}" placeholder="Enter event title" required class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-1.5 block text-sm font-medium text-slate-700">Description</label>
                        <textarea id="description" name="description" rows="6" placeholder="Describe the event agenda, highlights, etc..." required class="form-input min-h-[9.5rem] rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">{{ old('description', $event?->description) }}</textarea>
                        @error('description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                        <div>
                            <label for="start_date" class="mb-1.5 block text-sm font-medium text-slate-700">Date &amp; Time</label>
                            <div class="relative">
                                <button type="button" class="absolute left-2 top-1/2 z-10 flex h-7 w-7 -translate-y-1/2 items-center justify-center text-sky-500" aria-label="Pilih tanggal" onclick="document.getElementById('start_date').showPicker?.()">
                                    <i class="bi bi-calendar3 text-lg" aria-hidden="true"></i>
                                </button>
                                <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $event?->start_date?->format('Y-m-d')) }}" required class="date-input form-input h-11 rounded-xl border-slate-200 pl-12 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" style="padding-left: 3rem;">
                            </div>
                            @error('start_date') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="location" class="mb-1.5 block text-sm font-medium text-slate-700">Location</label>
                            <div class="relative">
                                <i class="bi bi-geo-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sky-500"></i>
                                <input id="location" name="location" value="{{ old('location', $event?->location) }}" placeholder="Enter event location" required class="form-input h-11 rounded-xl border-slate-200 pl-12 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" style="padding-left: 3rem;">
                            </div>
                            @error('location') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                        <div>
                            <label for="category_id" class="mb-1.5 block text-sm font-medium text-slate-700">Category</label>
                            <div class="relative">
                                <select id="category_id" name="category_id" required class="form-input h-11 rounded-xl border-slate-200 appearance-none pr-10 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $event?->category_id) == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            </div>
                            @error('category_id') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sponsor_ids" class="mb-1.5 block text-sm font-medium text-slate-700">Sponsor Multi-Select</label>
                            <div class="relative">
                                <select id="sponsor_ids" name="sponsor_ids[]" multiple size="1" class="form-input h-11 rounded-xl border-slate-200 appearance-none py-2 pr-10 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                                    @foreach ($sponsors as $sponsor)
                                        <option value="{{ $sponsor->id }}" @selected(in_array($sponsor->id, old('sponsor_ids', $event?->sponsors?->pluck('id')->all() ?? [])))>{{ $sponsor->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                        <div>
                            <label for="start_time" class="mb-1.5 block text-sm font-medium text-slate-700">Start Time</label>
                            <div class="relative">
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time', $event?->start_time) }}" class="time-input form-input h-11 rounded-xl border-slate-200 pr-12 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                                <i class="bi bi-clock pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sky-500" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div>
                            <label for="end_time" class="mb-1.5 block text-sm font-medium text-slate-700">End Time</label>
                            <div class="relative">
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time', $event?->end_time) }}" class="time-input form-input h-11 rounded-xl border-slate-200 pr-12 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                                <i class="bi bi-clock pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-sky-500" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div>
                            <label for="end_date" class="mb-1.5 block text-sm font-medium text-slate-700">End Date</label>
                            <div class="relative">
                                <i class="bi bi-calendar3 pointer-events-none absolute left-3 top-1/2 z-10 -translate-y-1/2 text-sky-500" aria-hidden="true"></i>
                                <input id="end_date" type="date" name="end_date" value="{{ old('end_date', $event?->end_date?->format('Y-m-d')) }}" class="date-input form-input h-11 rounded-xl border-slate-200 pl-12 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" style="padding-left: 3rem;">
                            </div>
                        </div>
                        <div>
                            <label for="organizer" class="mb-1.5 block text-sm font-medium text-slate-700">Organizer</label>
                            <input id="organizer" name="organizer" value="{{ old('organizer', $event?->organizer) }}" placeholder="Organizer name" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 md:grid-cols-2">
                        <div>
                            <label for="address" class="mb-1.5 block text-sm font-medium text-slate-700">Address</label>
                            <div class="relative">
                                <i class="bi bi-geo-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sky-500" aria-hidden="true"></i>
                                <input id="address" name="address" value="{{ old('address', $event?->address) }}" placeholder="Full address" class="form-input h-11 rounded-xl border-slate-200 pl-12 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" style="padding-left: 3rem;">
                            </div>
                        </div>
                        <div>
                            <label for="quota" class="mb-1.5 block text-sm font-medium text-slate-700">Quota</label>
                            <input id="quota" type="number" min="1" name="quota" value="{{ old('quota', $event?->quota) }}" placeholder="Optional quota" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                        </div>
                    </div>
                </section>

                <aside class="space-y-6">
                    <div>
                        <label class="mb-2 block text-base font-semibold text-slate-600">Upload Banner Image</label>
                        <label for="poster" class="group relative flex min-h-[275px] cursor-pointer items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-slate-800 bg-sky-950 p-4 text-center transition hover:border-sky-400">
                            @if ($event?->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }} banner" class="absolute inset-0 h-full w-full object-cover opacity-80">
                            @else
                                <div class="absolute inset-0 bg-[linear-gradient(145deg,#071b3a_0%,#075985_48%,#38bdf8_100%)] opacity-90"></div>
                                <div class="absolute bottom-0 left-0 right-0 h-1/3 bg-sky-400/20 [clip-path:polygon(0_70%,18%_35%,34%_65%,52%_20%,68%_60%,84%_30%,100%_58%,100%_100%,0_100%)]"></div>
                            @endif
                            <span class="relative flex flex-col items-center gap-3 rounded-xl bg-white/90 px-5 py-4 text-sm font-semibold text-sky-600 shadow-sm">
                                <i class="bi bi-upload text-2xl"></i>
                                <span>Change Banner</span>
                            </span>
                            <input id="poster" type="file" name="poster" accept="image/*" class="sr-only">
                        </label>
                        <p class="mt-2 text-xs text-slate-400">PNG, JPG up to 2MB</p>
                        @error('poster') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-base font-semibold text-slate-600">Status Toggle</p>
                                <p class="mt-1 text-sm font-semibold text-slate-800">Set as Active</p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="hidden" name="status" value="draft">
                                <input type="checkbox" name="status" value="ongoing" class="peer sr-only" @checked(old('status', $event?->status ?? 'draft') === 'ongoing')>
                                <span class="h-6 w-11 rounded-full bg-slate-300 after:absolute after:left-[3px] after:top-[3px] after:h-4 after:w-4 after:rounded-full after:bg-white after:transition-all peer-checked:bg-sky-500 peer-checked:after:translate-x-5"></span>
                            </label>
                        </div>
                    </div>
                </aside>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50/50 px-6 py-5 sm:px-8">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-sky-600"><i class="bi bi-check-lg"></i>Save Event</button>
            </div>
        </form>
    </div>
</div>
