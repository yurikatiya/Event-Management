<div class="min-h-[calc(100vh-4rem)] bg-blue-50/50 px-5 py-8 sm:px-8 lg:px-10">
	<div class="mx-auto max-w-[900px]">
		<div class="mb-6 rounded-[2.5rem] border border-blue-100 bg-white/90 p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
			<a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
				<i class="bi bi-arrow-left"></i>
				<span>Back to Categories</span>
			</a>
			<p class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-sky-600">Event Management</p>
			<h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ $title }}</h1>
			<p class="mt-2 text-sm text-slate-500">{{ $subtitle }}</p>
		</div>

		<form method="POST" action="{{ $formAction }}" class="rounded-[2.5rem] border border-blue-100 bg-white p-6 shadow-[0_12px_40px_rgba(59,130,246,0.06)] sm:p-8">
			@csrf
			@if ($method !== 'POST')
				@method($method)
			@endif

			<div class="space-y-6">
				<div>
					<label for="category-name" class="mb-2 block text-sm font-semibold text-slate-700">Category Name</label>
					<input id="category-name" name="name" value="{{ old('name', $category?->name) }}" required class="h-12 w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">
					@error('name')
						<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<label for="category-description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
					<textarea id="category-description" name="description" rows="6" class="w-full rounded-2xl border border-blue-100 bg-blue-50/50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-sky-300 focus:bg-white focus:ring-4 focus:ring-sky-100">{{ old('description', $category?->description) }}</textarea>
					@error('description')
						<p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div class="mt-8 flex flex-col-reverse gap-3 border-t border-blue-100 pt-5 sm:flex-row sm:justify-end">
				<a href="{{ route('admin.categories.index') }}" class="inline-flex h-11 items-center justify-center rounded-full border border-blue-100 bg-white px-5 text-sm font-semibold text-slate-600 transition hover:bg-blue-50">Cancel</a>
				<button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-full bg-sky-600 px-5 text-sm font-semibold text-white transition hover:bg-sky-700">
					<i class="bi bi-check-lg"></i>
					<span>Save Category</span>
				</button>
			</div>
		</form>
	</div>
</div>
