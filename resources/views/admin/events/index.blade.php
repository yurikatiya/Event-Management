<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | R27 CMS</title>
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
                <div><p class="mb-1 text-[9px] font-bold uppercase tracking-widest text-blue-600">Event management</p><h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Events</h1><p class="mt-1 text-[11px] text-slate-500">Kelola event publik R27 Creative Agency.</p></div>
                <a href="{{ route('admin.events.create') }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-blue-700"><i class="bi bi-plus-lg me-1"></i> Add Event</a>
            </div>
            @if (session('success'))<div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs text-emerald-700"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>@endif
            <div class="mb-4 flex flex-col gap-2 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row"><form class="flex flex-1 gap-2" method="GET"><div class="relative flex-1"><i class="bi bi-search absolute left-3 top-2.5 text-slate-400"></i><input name="search" value="{{ request('search') }}" placeholder="Search events..." class="h-9 w-full rounded-lg border border-slate-200 pl-9 pr-3 text-xs outline-none focus:border-blue-400"></div><select name="status" class="h-9 rounded-lg border border-slate-200 px-3 text-xs outline-none focus:border-blue-400"><option value="">All status</option>@foreach(['draft','upcoming','ongoing','completed','cancelled'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select><button class="rounded-lg bg-slate-900 px-3 text-xs font-semibold text-white"><i class="bi bi-funnel"></i></button></form></div>
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"><div class="overflow-x-auto"><table class="w-full min-w-[800px] text-left"><thead class="bg-slate-50 text-[9px] uppercase tracking-wider text-slate-400"><tr><th class="px-5 py-3">Event</th><th class="px-5 py-3">Category</th><th class="px-5 py-3">Date</th><th class="px-5 py-3">Location</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Action</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse($events as $event)<tr class="hover:bg-blue-50/30"><td class="px-5 py-4"><p class="text-xs font-bold text-slate-800">{{ $event->name }}</p><p class="mt-1 text-[10px] text-slate-400">{{ \Illuminate\Support\Str::limit($event->description, 45) }}</p></td><td class="px-5 py-4 text-xs text-slate-500">{{ $event->category?->name ?? '-' }}</td><td class="px-5 py-4 text-xs text-slate-500">{{ $event->start_date?->format('d M Y') }}</td><td class="px-5 py-4 text-xs text-slate-500">{{ $event->location }}</td><td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $event->status === 'cancelled' ? 'bg-red-50 text-red-600' : ($event->status === 'completed' ? 'bg-slate-100 text-slate-600' : 'bg-blue-50 text-blue-600') }}">{{ ucfirst($event->status) }}</span></td><td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.events.edit', $event) }}" class="rounded border border-slate-200 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600 hover:border-blue-300 hover:text-blue-600"><i class="bi bi-pencil"></i></a><form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini?')">@csrf @method('DELETE')<button class="rounded border border-red-100 px-2.5 py-1.5 text-[10px] text-red-500 hover:bg-red-50"><i class="bi bi-trash"></i></button></form></div></td></tr>@empty<tr><td colspan="6" class="px-5 py-12 text-center text-xs text-slate-400"><i class="bi bi-calendar2-x mb-2 block text-2xl"></i>Belum ada event.</td></tr>@endforelse</tbody></table></div>@if($events->hasPages())<div class="border-t border-slate-100 px-5 py-3">{{ $events->links() }}</div>@endif</div>
        </div>
    </main>
</div>
</body>
</html>