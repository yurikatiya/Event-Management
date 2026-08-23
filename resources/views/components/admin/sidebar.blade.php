<aside class="admin-sidebar border-r border-slate-200 bg-white">
    <div class="flex h-16 items-center gap-3 border-b border-slate-100 px-5">
        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500 text-sm font-bold text-white">R27</div>
        <div class="leading-tight"><p class="text-sm font-bold text-slate-900">R27 CMS</p><p class="text-[10px] text-slate-400">Creative Event Management</p></div>
    </div>
    <nav class="space-y-1 p-4">
        <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Workspace</p>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}"><i class="bi bi-grid-1x2-fill {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-slate-400' }}"></i>Dashboard</a>
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Event Management</p>
        <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.events.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}"><i class="bi bi-calendar-event {{ request()->routeIs('admin.events.*') ? 'text-blue-500' : 'text-slate-400' }}"></i>Events</a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}"><i class="bi bi-tags {{ request()->routeIs('admin.categories.*') ? 'text-blue-500' : 'text-slate-400' }}"></i>Categories</a>
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Company & Collaboration</p>
        @foreach ([['Services', 'bi-stars'], ['Sponsors', 'bi-award'], ['Partners', 'bi-link-45deg'], ['Teams', 'bi-people']] as [$label, $icon])
            <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-600"><i class="bi {{ $icon }} text-slate-400"></i>{{ $label }}</a>
        @endforeach
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Content Management</p>
        @foreach ([['Gallery', 'bi-images'], ['Company Profile', 'bi-building']] as [$label, $icon])
            <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-600"><i class="bi {{ $icon }} text-slate-400"></i>{{ $label }}</a>
        @endforeach
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">System</p>
        @foreach ([['Settings', 'bi-gear']] as [$label, $icon])
            <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-600"><i class="bi {{ $icon }} text-slate-400"></i>{{ $label }}</a>
        @endforeach
    </nav>
    <div class="mt-auto shrink-0 border-t border-slate-100 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-blue-50 p-3"><div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p><p class="text-[10px] text-slate-500">Administrator</p></div></div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf<button class="w-full rounded-xl px-3 py-2 text-left text-xs font-semibold text-slate-500 hover:bg-red-50 hover:text-red-600"><i class="bi bi-box-arrow-right me-2"></i>Logout</button></form>
    </div>
</aside>