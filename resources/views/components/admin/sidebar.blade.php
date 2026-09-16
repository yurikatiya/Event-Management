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
</aside>
