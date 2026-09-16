<aside class="admin-sidebar">
    <div class="sidebar-branding">
        <div class="brand-mark">
            <img src="{{ asset('Images/logo-r27.png') }}" alt="R27 logo" class="brand-r27-logo" />
        </div>
    </div>

    <div class="sidebar-menu-shell">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.events.index') }}" class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i>
                <span>Events</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
            </a>
            <a href="{{ route('admin.sponsors.index') }}" class="nav-item {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">
                <i class="bi bi-award"></i>
                <span>Sponsors</span>
            </a>
            <a href="{{ route('admin.partners.index') }}" class="nav-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                <i class="bi bi-link-45deg"></i>
                <span>Partners</span>
            </a>
            <a href="{{ route('admin.teams.index') }}" class="nav-item {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Teams</span>
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span>Gallery</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </nav>
    </div>
    <nav class="space-y-1 p-4">
        <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Workspace</p>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi bi-grid-1x2-fill {{ request()->routeIs('admin.dashboard') ? 'text-sky-500' : 'text-slate-400' }}"></i>Dashboard</a>
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Event Management</p>
        <a href="{{ route('admin.events.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.events.*') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi bi-calendar-event {{ request()->routeIs('admin.events.*') ? 'text-sky-500' : 'text-slate-400' }}"></i>Events</a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi bi-tags {{ request()->routeIs('admin.categories.*') ? 'text-sky-500' : 'text-slate-400' }}"></i>Categories</a>
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Company & Collaboration</p>
        @foreach ([['Services', 'bi-stars', 'admin.services.index', 'admin.services.*'], ['Sponsors', 'bi-award', null, null], ['Partners', 'bi-link-45deg', 'admin.partners.index', 'admin.partners.*'], ['Teams', 'bi-people', 'admin.teams.index', 'admin.teams.*']] as [$label, $icon, $route, $routePattern])
            <a href="{{ $route ? route($route) : '#' }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ $routePattern && request()->routeIs($routePattern) ? 'bg-sky-50 text-sky-500' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-500' }}"><i class="bi {{ $icon }} {{ $routePattern && request()->routeIs($routePattern) ? 'text-sky-500' : 'text-slate-400' }}"></i>{{ $label }}</a>
        @endforeach
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">Content Management</p>
        @foreach ([['Gallery', 'bi-images'], ['Company Profile', 'bi-building']] as [$label, $icon])
            <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-sky-50 hover:text-sky-500"><i class="bi {{ $icon }} text-slate-400"></i>{{ $label }}</a>
        @endforeach
        <p class="px-3 pb-2 pt-6 text-[10px] font-bold uppercase tracking-wider text-slate-400">System</p>
        @foreach ([['Settings', 'bi-gear']] as [$label, $icon])
            <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-sky-50 hover:text-sky-500"><i class="bi {{ $icon }} text-slate-400"></i>{{ $label }}</a>
        @endforeach
    </nav>
</aside>
