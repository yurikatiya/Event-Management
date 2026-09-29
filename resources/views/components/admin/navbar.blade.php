<header class="admin-navbar">
    <div class="admin-brand">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand-link" aria-label="R27 dashboard">
            <img src="{{ asset('Images/logo-r27.png') }}" alt="R27" class="admin-brand-logo" />
        </a>
    </div>

    <nav class="admin-topnav" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="topnav-item {{ request()->routeIs('admin.dashboard', 'admin.dashboard.legacy') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.events.index') }}" class="topnav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">Events</a>
        <a href="{{ route('admin.categories.index') }}" class="topnav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
        <a href="{{ route('admin.sponsors.index') }}" class="topnav-item {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">Sponsors</a>
        <a href="{{ route('admin.partners.index') }}" class="topnav-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">Partners</a>
        <a href="{{ route('admin.teams.index') }}" class="topnav-item {{ request()->routeIs('admin.teams.*') ? 'active' : '' }}">Teams</a>
        <a href="{{ route('admin.gallery.index') }}" class="topnav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">Gallery</a>
    </nav>

    <div class="admin-navbar-actions">
        <a href="{{ route('admin.settings') }}" class="settings-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="bi bi-gear"></i><span>Setting</span></a>
        <div class="relative navbar-search-wrap">
            <button type="button" data-search-toggle class="round-action" title="Search" aria-label="Search" aria-expanded="false" aria-controls="navbar-search">
                <i class="bi bi-search"></i>
            </button>
            <form id="navbar-search" data-navbar-search data-navbar-search-form class="navbar-search hidden">
                <i class="bi bi-search"></i>
                <input type="search" data-navbar-search-input placeholder="Search menu..." aria-label="Search menu" autocomplete="off" />
            </form>
        </div>
        <div class="relative">
            <button type="button" data-notification-menu-button class="round-action has-indicator" title="Notifications" aria-label="Notifications" aria-expanded="false">
                <i class="bi bi-bell"></i>
                <span class="notification-dot"></span>
            </button>
            <div data-notification-menu class="notification-menu hidden">
                <div class="menu-header">
                    <p>Notifikasi</p>
                </div>
                <div class="menu-empty">Belum ada notifikasi</div>
            </div>
        </div>

        <div class="relative">
            <button type="button" data-user-menu-button class="round-action" title="Profile" aria-label="Profile" aria-expanded="false">
                <i class="bi bi-person"></i>
            </button>
            <div data-user-menu class="user-menu hidden rounded-2xl border border-gray-100 bg-white p-2 shadow-lg">
                <a href="{{ route('admin.settings') }}" class="rounded-lg px-4 py-2.5 text-slate-600 transition hover:bg-gray-50"><i class="bi bi-person-circle"></i><span>Profile</span></a>
                <a href="{{ route('admin.settings') }}" class="rounded-lg px-4 py-2.5 text-slate-600 transition hover:bg-gray-50"><i class="bi bi-gear"></i><span>Settings</span></a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-gray-100 pt-2">@csrf<button type="submit" class="rounded-lg px-4 py-2.5 text-red-600 transition hover:bg-red-50"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
            </div>
        </div>
    </div>
</header>
