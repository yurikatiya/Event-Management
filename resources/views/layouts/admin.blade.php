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
@endphp
<body class="{{ $isDarkMode ? 'theme-dark' : 'theme-light' }} admin-body font-sans text-slate-700 antialiased">
    <div class="admin-app-shell">
        <x-admin.sidebar />
        <div class="admin-overlay" data-admin-overlay></div>
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
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('[data-admin-overlay]');
        const menuButton = document.querySelector('[data-admin-menu]');
        const themeToggle = document.querySelector('[data-theme-toggle]');
        const userMenuButton = document.querySelector('[data-user-menu-button]');
        const userMenu = document.querySelector('[data-user-menu]');
        const notificationButton = document.querySelector('[data-notification-menu-button]');
        const notificationMenu = document.querySelector('[data-notification-menu]');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const closeSidebar = () => {
            sidebar?.classList.remove('is-open');
            sidebar?.classList.add('is-collapsed');
            overlay?.classList.remove('is-visible');
        };

        const toggleSidebar = () => {
            if (window.innerWidth < 768) {
                sidebar?.classList.toggle('is-open');
                overlay?.classList.toggle('is-visible');
                return;
            }

            sidebar?.classList.toggle('is-collapsed');
        };

        menuButton?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', () => {
            sidebar?.classList.remove('is-open');
            overlay?.classList.remove('is-visible');
        });
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar?.classList.remove('is-open');
                overlay?.classList.remove('is-visible');
            }
        });

        const closeUserMenu = () => {
            userMenu?.classList.add('hidden');
            userMenuButton?.setAttribute('aria-expanded', 'false');
        };

        const closeNotificationMenu = () => {
            notificationMenu?.classList.add('hidden');
            notificationButton?.setAttribute('aria-expanded', 'false');
        };

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
            if (!userMenuButton?.contains(event.target) && !userMenu?.contains(event.target)) {
                closeUserMenu();
            }

            if (!notificationButton?.contains(event.target) && !notificationMenu?.contains(event.target)) {
                closeNotificationMenu();
            }
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
                    section: 'notification',
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

        const profileMenu = document.querySelector('[data-profile-menu]');
        const profileToggle = document.querySelector('[data-profile-toggle]');
        const profileDropdown = document.querySelector('[data-profile-dropdown]');
        const profileChevron = document.querySelector('[data-profile-chevron]');

        const closeProfileMenu = () => {
            profileDropdown?.classList.add('invisible', 'translate-y-2', 'opacity-0');
            profileDropdown?.classList.remove('visible', 'translate-y-0');
            profileToggle?.setAttribute('aria-expanded', 'false');
            profileChevron?.classList.remove('rotate-180');
        };

        profileToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            const isOpen = profileDropdown?.classList.contains('visible');
            if (isOpen) {
                closeProfileMenu();
                return;
            }
            profileDropdown?.classList.remove('invisible', 'translate-y-2', 'opacity-0');
            profileDropdown?.classList.add('visible', 'translate-y-0');
            profileToggle.setAttribute('aria-expanded', 'true');
            profileChevron?.classList.add('rotate-180');
        });
        document.addEventListener('click', (event) => {
            if (!profileMenu?.contains(event.target)) closeProfileMenu();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeProfileMenu();
        });
    </script>
    @stack('scripts')
</body>
</html>
