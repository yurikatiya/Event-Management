<header class="admin-navbar">
    <div class="topnav-left">
        <button type="button" data-admin-menu class="mobile-menu-button" title="Open navigation" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        @if (request()->routeIs('admin.dashboard', 'admin.dashboard.legacy'))
            <div class="topnav-search">
                <i class="bi bi-search"></i>
                <input type="search" placeholder="Search" />
            </div>
        @endif
    </div>

    <div class="admin-navbar-actions">
        <button type="button" data-theme-toggle class="icon-button" title="Toggle dark mode" aria-label="Toggle dark mode">
            <i class="bi bi-moon-stars"></i>
        </button>
        <div class="relative">
            <button type="button" data-notification-menu-button class="icon-button has-indicator" title="Notifications" aria-expanded="false">
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
            <button type="button" data-user-menu-button class="profile-button" aria-expanded="false">
                <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <span class="profile-name">{{ auth()->user()->name }}</span>
                <i class="bi bi-chevron-down"></i>
            </button>
            <div data-user-menu class="user-menu hidden">
                <a href="{{ route('admin.settings') }}"><i class="bi bi-person-circle"></i>Profile</a>
                <a href="{{ route('admin.settings') }}"><i class="bi bi-gear"></i>Settings</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"><i class="bi bi-box-arrow-right"></i>Logout</button></form>
            </div>
        </div>
    </div>
</header>
