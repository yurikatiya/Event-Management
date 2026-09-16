<header class="admin-navbar">
    <div class="topnav-left">
        <button type="button" data-admin-menu class="mobile-menu-button" title="Open navigation" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="topnav-search">
            <i class="bi bi-search"></i>
            <input type="search" placeholder="Search" />
        </div>
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
<header class="admin-navbar sticky top-0 z-10 flex min-h-16 w-full items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
    <div class="flex min-w-0 flex-1 items-center gap-3"><button type="button" data-admin-menu class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-blue-50 hover:text-blue-600 lg:hidden" title="Open navigation"><i class="bi bi-list text-lg"></i></button><div class="relative w-full max-w-md"><i class="bi bi-search absolute left-3 top-2.5 text-sm text-slate-400"></i><input type="search" placeholder="Search events, partners, reports" class="h-9 w-full rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 text-xs outline-none transition focus:border-blue-400 focus:bg-white"></div></div>
    <div class="admin-navbar-actions">
        <button class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition hover:bg-blue-50 hover:text-blue-600" title="Notifications"><i class="bi bi-bell"></i><span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-red-500"></span></button>
        <div class="relative" data-profile-menu>
            <button type="button" data-profile-toggle aria-expanded="false" class="admin-navbar-profile rounded-xl px-2 py-1.5 transition hover:bg-blue-50">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div class="hidden whitespace-nowrap text-left sm:block"><p class="text-xs font-semibold text-slate-800">{{ auth()->user()->name }}</p><p class="text-[10px] text-slate-400">Admin R27</p></div>
                <i data-profile-chevron class="bi bi-chevron-down shrink-0 text-[10px] text-slate-400 transition-transform"></i>
            </button>
            <div data-profile-dropdown class="invisible absolute right-0 top-14 z-30 w-60 origin-top-right translate-y-2 rounded-2xl border border-slate-100 bg-white p-2 opacity-0 shadow-xl shadow-slate-200/60 transition-all duration-200">
                <div class="mb-1 border-b border-slate-100 px-3 py-2"><p class="truncate text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p><p class="text-xs text-slate-400">Administrator</p></div>
                <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-600"><i class="bi bi-person text-base text-slate-400"></i><span>Profile</span></a>
                <a href="#" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-600"><i class="bi bi-gear text-base text-slate-400"></i><span>Account Settings</span></a>
                <div class="my-1 border-t border-slate-100"></div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-red-500 transition hover:bg-red-50 hover:text-red-600"><i class="bi bi-box-arrow-right text-base"></i><span>Logout</span></button></form>
            </div>
        </div>
    </div>
</header>
