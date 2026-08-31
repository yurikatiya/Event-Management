<aside class="admin-sidebar border-r border-slate-200 bg-white">
    <div class="flex h-16 items-center border-b border-slate-100 px-5">
        <img src="{{ asset('Images/logo-r27.png') }}" alt="R27 logo" class="h-10 w-auto object-contain" />
    </div>
    <nav class="space-y-1 p-4">
        <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Workspace</p>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi bi-grid-1x2-fill {{ request()->routeIs('admin.dashboard') ? 'text-sky-500' : 'text-slate-400' }}"></i>Dashboard</a>
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Event Management</p>
        <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.events.*') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi bi-calendar-event {{ request()->routeIs('admin.events.*') ? 'text-sky-500' : 'text-slate-400' }}"></i>Events</a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi bi-tags {{ request()->routeIs('admin.categories.*') ? 'text-sky-500' : 'text-slate-400' }}"></i>Categories</a>
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Company & Collaboration</p>
        @foreach ([['Services', 'bi-stars', 'admin.services.index', 'admin.services.*'], ['Sponsors', 'bi-award', 'admin.sponsors.index', 'admin.sponsors.*'], ['Partners', 'bi-link-45deg', 'admin.partners.index', 'admin.partners.*'], ['Teams', 'bi-people', 'admin.teams.index', 'admin.teams.*']] as [$label, $icon, $route, $routePattern])
            <a href="{{ $route ? route($route) : '#' }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ $routePattern && request()->routeIs($routePattern) ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi {{ $icon }} {{ $routePattern && request()->routeIs($routePattern) ? 'text-sky-500' : 'text-slate-400' }}"></i>{{ $label }}</a>
        @endforeach
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Content Management</p>
        @foreach ([['Gallery', 'bi-images', 'admin.gallery.index'], ['Company Profile', 'bi-building', null]] as [$label, $icon, $route])
            <a href="{{ $route ? route($route) : '#' }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ $route && request()->routeIs('admin.gallery.*') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi {{ $icon }} {{ $route && request()->routeIs('admin.gallery.*') ? 'text-sky-500' : 'text-slate-400' }}"></i>{{ $label }}</a>
        @endforeach
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">System</p>
        @foreach ([['Settings', 'bi-gear', 'admin.settings']] as [$label, $icon, $route])
            <a href="{{ route($route) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.settings') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi {{ $icon }} {{ request()->routeIs('admin.settings') ? 'text-sky-500' : 'text-slate-400' }}"></i>{{ $label }}</a>
        @endforeach
    </nav>
    <div class="mt-auto shrink-0 border-t border-slate-100 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-blue-50 p-3"><div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p><p class="text-[10px] text-slate-500">Administrator</p></div></div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf<button class="w-full rounded-xl px-3 py-2 text-left text-xs font-semibold text-slate-500 hover:bg-red-50 hover:text-red-600"><i class="bi bi-box-arrow-right me-2"></i>Logout</button></form>
    </div>
</aside>