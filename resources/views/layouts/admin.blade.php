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

        const showImageUploadAlert = (message, title = 'Upload gagal') => {
            let container = document.querySelector('[data-gallery-alerts]');
            if (!container) {
                container = document.createElement('div');
                container.className = 'gallery-upload-alerts';
                container.dataset.galleryAlerts = '';
                document.querySelector('main')?.prepend(container);
            }

            const alert = document.createElement('div');
            alert.className = 'gallery-upload-alert';
            alert.setAttribute('role', 'alert');
            alert.innerHTML = '<i class="bi bi-exclamation-circle-fill" aria-hidden="true"></i><div><strong></strong><span></span></div><button type="button" aria-label="Tutup notifikasi"><i class="bi bi-x-lg" aria-hidden="true"></i></button>';
            alert.querySelector('strong').textContent = title;
            alert.querySelector('span').textContent = message;

            const dismiss = () => {
                alert.classList.add('is-closing');
                window.setTimeout(() => alert.remove(), 180);
            };

            alert.querySelector('button').addEventListener('click', dismiss);
            container.append(alert);
            window.setTimeout(() => {
                if (alert.isConnected) dismiss();
            }, 6000);
        };

        document.querySelectorAll('input[type="file"][data-image-preview]').forEach((input) => {
            input.addEventListener('change', () => {
                const file = input.files?.[0];
                if (!file) return;

                if (file.size > 2 * 1024 * 1024) {
                    input.value = '';
                    showImageUploadAlert(`${file.name} melebihi batas 2 MB. Pilih gambar yang lebih kecil.`);
                    return;
                }

                const preview = input.closest('[data-image-upload]')?.querySelector('[data-image-preview-target]')
                    ?? document.querySelector(`[data-image-preview-target-for="${input.id}"]`);
                if (!preview) return;

                if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
                preview.dataset.objectUrl = URL.createObjectURL(file);
                preview.src = preview.dataset.objectUrl;
                preview.hidden = false;
            });
        });

        let liveSearchTimer;
        let liveSearchController;
        const requestLiveSearch = async (form, {url = null, historyMode = 'replace'} = {}) => {
            const resultTarget = document.querySelector('[data-live-search-results]');
            if (!resultTarget) return false;

            const targetUrl = url ?? new URL(form.action || window.location.href, window.location.href);
            if (!url) {
                const formData = new FormData(form);
                targetUrl.search = '';
                for (const [key, value] of formData.entries()) {
                    if (typeof value === 'string' && value !== '') targetUrl.searchParams.append(key, value);
                }
            } else if (form) {
                Array.from(form.elements).forEach((field) => {
                    if (field.name && targetUrl.searchParams.has(field.name)) {
                        field.value = targetUrl.searchParams.get(field.name);
                    } else if (field.name === 'search') {
                        field.value = '';
                    }
                });
            }
            targetUrl.searchParams.delete('page');

            liveSearchController?.abort();
            const requestController = new AbortController();
            liveSearchController = requestController;
            resultTarget.classList.add('is-searching');

            try {
                const response = await fetch(targetUrl, {
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html'},
                    signal: requestController.signal,
                });
                if (!response.ok) throw new Error(`Pencarian gagal (${response.status}).`);

                const html = new DOMParser().parseFromString(await response.text(), 'text/html');
                const nextResults = html.querySelector('[data-live-search-results]');
                if (!nextResults) {
                    window.location.assign(targetUrl);
                    return true;
                }

                resultTarget.innerHTML = nextResults.innerHTML;
                document.querySelectorAll('[data-live-search-summary]').forEach((summary, index) => {
                    const nextSummary = html.querySelectorAll('[data-live-search-summary]')[index];
                    if (nextSummary) summary.innerHTML = nextSummary.innerHTML;
                });
                document.title = html.title;

                if (historyMode === 'push') window.history.pushState({}, '', targetUrl);
                else window.history.replaceState({}, '', targetUrl);

                return true;
            } catch (error) {
                if (error.name !== 'AbortError' && !requestController.signal.aborted) {
                    console.error(error);
                    resultTarget.classList.remove('is-searching');
                    showImageUploadAlert(error.message, 'Pencarian gagal');
                }
                return false;
            } finally {
                if (liveSearchController === requestController) resultTarget.classList.remove('is-searching');
            }
        };

        document.addEventListener('input', (event) => {
            const input = event.target.closest('form[data-live-search] input[name="search"]');
            if (!input) return;

            window.clearTimeout(liveSearchTimer);
            liveSearchTimer = window.setTimeout(() => {
                requestLiveSearch(input.form);
            }, 220);
        });

        document.addEventListener('submit', (event) => {
            const form = event.target.closest('form[data-live-search]');
            if (!form) return;

            event.preventDefault();
            window.clearTimeout(liveSearchTimer);
            requestLiveSearch(form);
        });

        document.addEventListener('click', (event) => {
            const link = event.target.closest('[data-live-search-results] nav a[href], [data-live-search-results] .pagination a[href]');
            if (!link || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0) return;

            const targetUrl = new URL(link.href, window.location.href);
            if (targetUrl.origin !== window.location.origin) return;
            event.preventDefault();
            requestLiveSearch(document.querySelector('form[data-live-search]'), {url: targetUrl, historyMode: 'push'});
        });

        window.addEventListener('popstate', () => {
            const form = document.querySelector('form[data-live-search]');
            if (form) requestLiveSearch(form, {url: new URL(window.location.href)});
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
