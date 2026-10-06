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
                loadAdminNotifications();
            } else {
                closeNotificationMenu();
            }
        });

        const notificationsList = notificationMenu?.querySelector('[data-notifications-list]');
        const notificationCount = document.querySelector('[data-notification-count]');
        const readAllButton = notificationMenu?.querySelector('[data-notifications-read-all]');
        let notificationsRequestInProgress = false;

        const renderNotificationError = (message) => {
            if (!notificationsList) return;
            notificationsList.replaceChildren();
            const error = document.createElement('div');
            error.className = 'menu-empty text-rose-600';
            error.textContent = message;
            notificationsList.append(error);
        };

        const loadAdminNotifications = async () => {
            if (!notificationMenu || notificationsRequestInProgress || document.hidden) return;
            notificationsRequestInProgress = true;

            try {
                const response = await fetch(notificationMenu.dataset.notificationsUrl, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });
                if (!response.ok) throw new Error(`Request notifikasi gagal (${response.status}).`);

                const data = await response.json();
                const unreadCount = data.enabled ? data.unread_count : 0;
                notificationCount?.classList.toggle('hidden', unreadCount === 0);
                if (notificationCount) notificationCount.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
                notificationButton?.setAttribute('aria-label', unreadCount ? `Notifikasi, ${unreadCount} belum dibaca` : 'Notifikasi');
                readAllButton?.classList.toggle('hidden', unreadCount === 0);

                if (!notificationsList) return;
                notificationsList.replaceChildren();
                if (!data.enabled || data.items.length === 0) {
                    const empty = document.createElement('div');
                    empty.className = 'menu-empty';
                    empty.textContent = data.enabled ? 'Belum ada notifikasi' : 'Notifikasi sedang dinonaktifkan';
                    notificationsList.append(empty);
                    return;
                }

                data.items.forEach((item) => {
                    const link = document.createElement('a');
                    link.className = `notification-item${item.read_at ? '' : ' is-unread'}`;
                    link.href = item.url;
                    link.dataset.notificationReadUrl = item.read_url;

                    const icon = document.createElement('span');
                    icon.className = 'notification-item-icon';
                    const iconElement = document.createElement('i');
                    iconElement.className = `bi ${item.icon}`;
                    icon.append(iconElement);

                    const copy = document.createElement('span');
                    copy.className = 'notification-item-copy';
                    const title = document.createElement('span');
                    title.className = 'notification-item-title';
                    title.textContent = item.title;
                    const message = document.createElement('span');
                    message.className = 'notification-item-message';
                    message.textContent = item.message;
                    const time = document.createElement('span');
                    time.className = 'notification-item-time';
                    time.textContent = item.time_ago;
                    copy.append(title, message, time);
                    link.append(icon, copy);
                    notificationsList.append(link);
                });
            } catch (error) {
                console.error(error);
                if (!notificationMenu.classList.contains('hidden')) {
                    renderNotificationError('Notifikasi gagal dimuat. Coba buka kembali menu ini.');
                }
            } finally {
                notificationsRequestInProgress = false;
            }
        };

        notificationsList?.addEventListener('click', async (event) => {
            const link = event.target.closest('[data-notification-read-url]');
            if (!link || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
            event.preventDefault();

            try {
                const response = await fetch(link.dataset.notificationReadUrl, {
                    method: 'PATCH',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                });
                if (!response.ok) throw new Error(`Notifikasi gagal ditandai dibaca (${response.status}).`);
                window.location.assign(link.href);
            } catch (error) {
                console.error(error);
                renderNotificationError('Notifikasi tidak dapat ditandai dibaca. Silakan coba lagi.');
            }
        });

        readAllButton?.addEventListener('click', async () => {
            try {
                const response = await fetch(notificationMenu.dataset.markAllUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                });
                if (!response.ok) throw new Error(`Notifikasi gagal diperbarui (${response.status}).`);
                await loadAdminNotifications();
            } catch (error) {
                console.error(error);
                renderNotificationError('Notifikasi gagal ditandai dibaca. Silakan coba lagi.');
            }
        });

        loadAdminNotifications();
        window.setInterval(loadAdminNotifications, 10000);
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) loadAdminNotifications();
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

        const syncCustomSelect = (select) => {
            const wrapper = select.closest('[data-custom-select]');
            const trigger = wrapper?.querySelector('[data-custom-select-trigger]');
            const label = wrapper?.querySelector('[data-custom-select-label]');
            const menu = wrapper?.querySelector('[data-custom-select-menu]');
            if (!wrapper || !trigger || !label || !menu) return;

            const selectedOptions = Array.from(select.selectedOptions);
            const placeholder = !select.multiple && select.options[0]?.value === ''
                ? select.options[0].textContent.trim()
                : 'Pilih opsi';
            if (select.multiple) {
                label.textContent = selectedOptions.length
                    ? selectedOptions.map((option) => option.textContent.trim()).join(', ')
                    : placeholder;
            } else {
                label.textContent = selectedOptions[0]?.textContent.trim() || placeholder;
            }

            menu.querySelectorAll('[data-custom-select-option]').forEach((button) => {
                const option = select.options[Number(button.dataset.optionIndex)];
                const isSelected = Boolean(option?.selected);
                button.setAttribute('aria-selected', String(isSelected));
                button.querySelector('[data-custom-select-check]')?.classList.toggle('is-selected', isSelected);
            });
            trigger.setAttribute('aria-invalid', 'false');
            wrapper.querySelector('[data-custom-select-error]')?.remove();
        };

        const enhanceSelect = (select) => {
            if (select.dataset.customSelectEnhanced === 'true' || select.size > 1) return;

            const formLabel = select.labels ? Array.from(select.labels).map((item) => item.textContent.trim()).join(' ') : '';
            const accessibleName = select.getAttribute('aria-label') || formLabel || select.options[0]?.textContent.trim() || select.name;
            const isRequired = select.required;
            const isFullWidth = select.classList.contains('w-full')
                || select.classList.contains('form-input')
                || Boolean(select.closest('.crud-form-panel, .gallery-form-field'));
            const wrapper = document.createElement('div');
            wrapper.className = 'custom-select';
            wrapper.dataset.customSelect = '';
            if (isFullWidth) wrapper.classList.add('custom-select-full');
            if (select.multiple) wrapper.classList.add('custom-select-multiple');

            select.parentNode.insertBefore(wrapper, select);
            wrapper.append(select);
            select.dataset.customSelectEnhanced = 'true';
            select.classList.add('custom-select-native');
            select.setAttribute('aria-hidden', 'true');
            select.tabIndex = -1;
            if (isRequired) {
                select.dataset.customSelectRequired = 'true';
                select.required = false;
            }

            const trigger = document.createElement('button');
            trigger.type = 'button';
            trigger.className = 'custom-select-trigger';
            trigger.dataset.customSelectTrigger = '';
            trigger.setAttribute('aria-haspopup', 'listbox');
            trigger.setAttribute('aria-expanded', 'false');
            trigger.setAttribute('aria-label', accessibleName);
            if (isRequired) trigger.setAttribute('aria-required', 'true');
            if (select.disabled) trigger.disabled = true;
            const label = document.createElement('span');
            label.className = 'custom-select-label';
            label.dataset.customSelectLabel = '';
            const arrow = document.createElement('span');
            arrow.className = 'custom-select-arrow';
            arrow.setAttribute('aria-hidden', 'true');
            trigger.append(label, arrow);

            const menu = document.createElement('div');
            menu.className = 'custom-select-menu';
            menu.dataset.customSelectMenu = '';
            menu.setAttribute('role', 'listbox');
            menu.setAttribute('aria-label', accessibleName);
            menu.setAttribute('aria-multiselectable', String(select.multiple));
            menu.hidden = true;

            Array.from(select.options).forEach((option, index) => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'custom-select-option';
                item.dataset.customSelectOption = '';
                item.dataset.optionIndex = String(index);
                item.setAttribute('role', 'option');
                item.setAttribute('aria-selected', String(option.selected));
                item.disabled = option.disabled;
                const text = document.createElement('span');
                text.className = 'custom-select-option-text';
                text.textContent = option.textContent.trim() || 'Pilih opsi';
                const check = document.createElement('span');
                check.className = 'custom-select-check';
                check.dataset.customSelectCheck = '';
                check.setAttribute('aria-hidden', 'true');
                item.append(text, check);
                menu.append(item);
            });

            wrapper.append(trigger, menu);
            select.addEventListener('change', () => syncCustomSelect(select));
            select.form?.addEventListener('reset', () => window.setTimeout(() => syncCustomSelect(select), 0));
            syncCustomSelect(select);
        };

        const enhanceSelects = (root = document) => {
            root.querySelectorAll('select').forEach(enhanceSelect);
        };

        const closeCustomSelect = (wrapper, {restoreFocus = false} = {}) => {
            const trigger = wrapper.querySelector('[data-custom-select-trigger]');
            const menu = wrapper.querySelector('[data-custom-select-menu]');
            if (!trigger || !menu || menu.hidden) return;
            menu.hidden = true;
            trigger.setAttribute('aria-expanded', 'false');
            wrapper.classList.remove('is-open');
            if (restoreFocus) trigger.focus();
        };

        const openCustomSelect = (wrapper, focusSelected = true) => {
            document.querySelectorAll('[data-custom-select].is-open').forEach((openWrapper) => {
                if (openWrapper !== wrapper) closeCustomSelect(openWrapper);
            });
            const trigger = wrapper.querySelector('[data-custom-select-trigger]');
            const menu = wrapper.querySelector('[data-custom-select-menu]');
            menu.hidden = false;
            trigger.setAttribute('aria-expanded', 'true');
            wrapper.classList.add('is-open');
            const options = Array.from(menu.querySelectorAll('[data-custom-select-option]:not(:disabled)'));
            const select = wrapper.querySelector('select');
            const selectedIndex = Array.from(select.options).findIndex((option) => option.selected);
            (focusSelected ? options.find((item) => Number(item.dataset.optionIndex) === selectedIndex) : options[0])?.focus();
        };

        enhanceSelects();

        document.addEventListener('click', (event) => {
            const trigger = event.target.closest('[data-custom-select-trigger]');
            if (trigger) {
                const wrapper = trigger.closest('[data-custom-select]');
                if (trigger.getAttribute('aria-expanded') === 'true') closeCustomSelect(wrapper);
                else openCustomSelect(wrapper);
                return;
            }

            const optionButton = event.target.closest('[data-custom-select-option]');
            if (optionButton) {
                const wrapper = optionButton.closest('[data-custom-select]');
                const select = wrapper.querySelector('select');
                const option = select.options[Number(optionButton.dataset.optionIndex)];
                if (!option || option.disabled) return;

                if (select.multiple) option.selected = !option.selected;
                else {
                    select.selectedIndex = Number(optionButton.dataset.optionIndex);
                    closeCustomSelect(wrapper);
                }
                select.dispatchEvent(new Event('change', {bubbles: true}));
                if (select.multiple) optionButton.focus();
                else wrapper.querySelector('[data-custom-select-trigger]').focus();
                return;
            }

            if (!event.target.closest('[data-custom-select]')) {
                document.querySelectorAll('[data-custom-select].is-open').forEach((wrapper) => closeCustomSelect(wrapper));
            }
        });

        document.addEventListener('keydown', (event) => {
            const wrapper = event.target.closest('[data-custom-select]');
            if (!wrapper) return;
            const trigger = event.target.closest('[data-custom-select-trigger]');
            const option = event.target.closest('[data-custom-select-option]');
            const options = Array.from(wrapper.querySelectorAll('[data-custom-select-option]:not(:disabled)'));

            if (trigger && ['ArrowDown', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                openCustomSelect(wrapper, event.key === 'ArrowDown');
                return;
            }
            if (event.key === 'Escape') {
                event.preventDefault();
                closeCustomSelect(wrapper, {restoreFocus: true});
                return;
            }
            if (!option) return;

            const index = options.indexOf(option);
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                options[(index + (event.key === 'ArrowDown' ? 1 : -1) + options.length) % options.length]?.focus();
            } else if (event.key === 'Home' || event.key === 'End') {
                event.preventDefault();
                (event.key === 'Home' ? options[0] : options.at(-1))?.focus();
            } else if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                option.click();
            } else if (!wrapper.querySelector('select').multiple && event.key.length === 1) {
                const matchingOption = options.find((item) =>
                    item.textContent.trim().toLocaleLowerCase().startsWith(event.key.toLocaleLowerCase())
                );
                matchingOption?.focus();
            }
        });

        document.addEventListener('submit', (event) => {
            const invalidWrapper = Array.from(event.target.querySelectorAll('[data-custom-select]'))
                .find((wrapper) => wrapper.querySelector('select[data-custom-select-required]')?.selectedOptions.length === 0);
            if (!invalidWrapper) return;

            event.preventDefault();
            const trigger = invalidWrapper.querySelector('[data-custom-select-trigger]');
            trigger.setAttribute('aria-invalid', 'true');
            let error = invalidWrapper.querySelector('[data-custom-select-error]');
            if (!error) {
                error = document.createElement('span');
                error.className = 'custom-select-error';
                error.dataset.customSelectError = '';
                error.textContent = 'Pilih salah satu opsi.';
                invalidWrapper.append(error);
            }
            trigger.focus();
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
                        if (field instanceof HTMLSelectElement) syncCustomSelect(field);
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
                enhanceSelects(resultTarget);
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
