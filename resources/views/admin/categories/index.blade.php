<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Event | INCO CMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-700 antialiased">
    <div class="admin-shell">
        @include('admin.categories.partials.sidebar')
        <main class="admin-main">
            @include('admin.categories.partials.topbar')
            <div class="p-4 sm:p-6">
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div><p class="mb-1 text-[9px] font-bold uppercase tracking-widest text-blue-600">Content management</p><h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Kategori Event</h1><p class="mt-1 text-[11px] text-slate-500">Kelola pengelompokan event agar mudah ditemukan.</p></div>
                    <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">＋ Tambah Kategori</a>
                </div>
                @if (session('success'))<div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-700">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">{{ session('error') }}</div>@endif
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4"><div><h2 class="text-sm font-bold text-slate-800">Daftar Kategori</h2><p class="mt-1 text-[10px] text-slate-400">{{ $categories->total() }} kategori terdaftar</p></div><span class="rounded bg-blue-50 px-2.5 py-1 text-[10px] font-bold text-blue-600">Event taxonomy</span></div>
                    <div class="overflow-x-auto"><table class="w-full min-w-[650px] text-left"><thead class="bg-slate-50 text-[9px] uppercase tracking-wider text-slate-400"><tr><th class="px-5 py-3 font-bold">ID</th><th class="px-5 py-3 font-bold">Nama</th><th class="px-5 py-3 font-bold">Deskripsi</th><th class="px-5 py-3 font-bold">Total Event</th><th class="px-5 py-3 text-right font-bold">Aksi</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse ($categories as $category)<tr class="hover:bg-blue-50/30"><td class="px-5 py-4 text-xs text-slate-400">#{{ $category->id }}</td><td class="px-5 py-4 text-xs font-bold text-slate-800">{{ $category->name }}</td><td class="max-w-md px-5 py-4 text-xs text-slate-500">{{ $category->description ? \Illuminate\Support\Str::limit($category->description, 80) : 'Belum ada deskripsi' }}</td><td class="px-5 py-4"><span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold text-blue-600">{{ $category->events_count }} event</span></td><td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.categories.edit', $category) }}" class="rounded border border-slate-200 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 hover:border-blue-300 hover:text-blue-600">Edit</a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button class="rounded border border-red-100 px-2.5 py-1.5 text-[10px] font-semibold text-red-500 hover:bg-red-50">Hapus</button></form></div></td></tr>@empty<tr><td colspan="5" class="px-5 py-12 text-center text-xs text-slate-400">Belum ada kategori.</td></tr>@endforelse</tbody></table></div>
                    @if ($categories->hasPages())<div class="border-t border-slate-100 px-5 py-3">{{ $categories->links() }}</div>@endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>