<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | R27 CMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
@php
    $isDarkMode = (bool) (auth()->user()?->dark_mode ?? false);
    $toastMessages = collect();

    if (session('success')) {
        $toastMessages->push(['type' => 'success', 'message' => session('success')]);
    }

    if (session('error')) {
        $toastMessages->push(['type' => 'error', 'message' => session('error')]);
    }

    $searchRoutes = [
        'dashboard' => route('admin.dashboard'),
        'event' => route('admin.events.index'),
        'category' => route('admin.categories.index'),
        'sponsor' => route('admin.sponsors.index'),
        'partner' => route('admin.partners.index'),
        'team' => route('admin.teams.index'),
        'gallery' => route('admin.gallery.index'),
        'setting' => route('admin.settings'),
    ];
@endphp
<body class="{{ $isDarkMode ? 'theme-dark' : 'theme-light' }} admin-body font-sans text-slate-700 antialiased">
    <div class="admin-app-shell">
        <div class="admin-main">
            <x-admin.navbar />
            <main class="min-w-0">
                @yield('content')
            </main>
        </div>
    </div>

    @if ($toastMessages->isNotEmpty())
        <div class="toast-container" aria-live="polite" aria-atomic="true">
            @foreach ($toastMessages as $toast)
                <x-admin.toast type="{{ $toast['type'] }}" message="{{ $toast['message'] }}" />
            @endforeach
        </div>
    @endif

    <script>
        const themeToggle = document.querySelector('[data-theme-toggle]');
        const searchToggle = document.querySelector('[data-search-toggle]');
        const searchPanel = document.querySelector('[data-navbar-search]');
        const searchInput = document.querySelector('[data-navbar-search-input]');
        const searchForm = document.querySelector('[data-navbar-search-form]');
        const searchRoutes = {{ Illuminate\Support\Js::from($searchRoutes) }};
        const adminTopNav = document.querySelector('[data-admin-topnav]');
        const userMenuButton = document.querySelector('[data-user-menu-button]');
        const userMenu = document.querySelector('[data-user-menu]');
        const notificationButton = document.querySelector('[data-notification-menu-button]');
        const notificationMenu = document.querySelector('[data-notification-menu]');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const closeUserMenu = () => {
            userMenu?.classList.add('hidden');
            userMenuButton?.setAttribute('aria-expanded', 'false');
        };

        const closeNotificationMenu = () => {
            notificationMenu?.classList.add('hidden');
            notificationButton?.setAttribute('aria-expanded', 'false');
        };

        const closeSearch = () => {
            searchPanel?.classList.add('hidden');
            searchToggle?.setAttribute('aria-expanded', 'false');
        };

        const setActiveTopNavItem = (activeItem) => {
            adminTopNav?.querySelectorAll('[data-topnav-item]').forEach((item) => {
                const isActive = item === activeItem;
                item.classList.toggle('active', isActive);
                if (isActive) {
                    item.setAttribute('aria-current', 'page');
                } else {
                    item.removeAttribute('aria-current');
                }
            });
        };

        const currentTopNavItem = adminTopNav?.querySelector('[data-topnav-item].active');
        if (currentTopNavItem) {
            currentTopNavItem.setAttribute('aria-current', 'page');
            requestAnimationFrame(() => {
                adminTopNav.scrollLeft = Math.max(0, currentTopNavItem.offsetLeft - (adminTopNav.clientWidth - currentTopNavItem.offsetWidth) / 2);
            });
        }

        adminTopNav?.addEventListener('click', (event) => {
            const item = event.target.closest('[data-topnav-item]');
            if (!item || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || item.target === '_blank') {
                return;
            }

            setActiveTopNavItem(item);
            requestAnimationFrame(() => {
                adminTopNav.scrollTo({
                    left: Math.max(0, item.offsetLeft - (adminTopNav.clientWidth - item.offsetWidth) / 2),
                    behavior: 'smooth',
                });
            });
        });

        searchToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = searchPanel?.classList.contains('hidden');
            closeUserMenu();
            closeNotificationMenu();
            if (isHidden) {
                searchPanel?.classList.remove('hidden');
                searchToggle?.setAttribute('aria-expanded', 'true');
                window.requestAnimationFrame(() => searchInput?.focus());
            } else {
                closeSearch();
            }
        });

        searchForm?.addEventListener('submit', (event) => {
            event.preventDefault();
            const query = searchInput?.value.trim().toLowerCase() ?? '';
            const matchedRoute = Object.entries(searchRoutes).find(([keyword]) => query.includes(keyword));

            if (matchedRoute) {
                window.location.href = matchedRoute[1];
                return;
            }

            searchInput?.focus();
        });

        userMenuButton?.addEventListener('click', (event) => {
            event.stopPropagation();
            closeNotificationMenu();
            const isHidden = userMenu?.classList.contains('hidden');
            if (isHidden) {
                userMenu?.classList.remove('hidden');
                userMenuButton?.setAttribute('aria-expanded', 'true');
            } else {
                closeUserMenu();
            }
        });

        notificationButton?.addEventListener('click', (event) => {
            event.stopPropagation();
            closeUserMenu();
            const isHidden = notificationMenu?.classList.contains('hidden');
            if (isHidden) {
                notificationMenu?.classList.remove('hidden');
                notificationButton?.setAttribute('aria-expanded', 'true');
            } else {
                closeNotificationMenu();
            }
        });

        document.addEventListener('click', (event) => {
            if (!searchToggle?.contains(event.target) && !searchPanel?.contains(event.target)) {
                closeSearch();
            }

            if (!userMenuButton?.contains(event.target) && !userMenu?.contains(event.target)) {
                closeUserMenu();
            }

            if (!notificationButton?.contains(event.target) && !notificationMenu?.contains(event.target)) {
                closeNotificationMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeSearch();
        });

        const applyTheme = (isDark) => {
            document.body.classList.toggle('theme-dark', isDark);
            document.body.classList.toggle('theme-light', !isDark);
            const icon = themeToggle?.querySelector('i');
            if (icon) {
                icon.className = isDark ? 'bi bi-sun-fill text-base' : 'bi bi-moon-stars text-base';
            }
        };

        const syncThemePreference = (isDark) => {
            if (!csrfToken) return;

            fetch('{{ route('admin.settings.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: new URLSearchParams({
                    section: 'appearance',
                    dark_mode: isDark ? '1' : '0',
                }).toString(),
            }).catch(() => {});
        };

        document.querySelectorAll('[data-toast-item]').forEach((toast) => {
            const closeToast = () => {
                toast.classList.add('is-closing');
                window.setTimeout(() => toast.remove(), 180);
            };

            const dismissButton = toast.querySelector('[data-toast-close]');
            dismissButton?.addEventListener('click', (event) => {
                event.stopPropagation();
                closeToast();
            });

            toast.addEventListener('click', (event) => {
                if (!event.target.closest('[data-toast-close]')) {
                    closeToast();
                }
            });

            window.setTimeout(closeToast, 4000);
        });

        const isDarkModeEnabled = document.body.classList.contains('theme-dark');
        applyTheme(isDarkModeEnabled);
        themeToggle?.addEventListener('click', () => {
            const nextDarkMode = !document.body.classList.contains('theme-dark');
            applyTheme(nextDarkMode);
            syncThemePreference(nextDarkMode);
        });

    </script>
    @stack('scripts')
</body>
</html>
