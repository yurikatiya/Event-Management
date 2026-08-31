<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | R27 CMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
@php
    $isDarkMode = (bool) (auth()->user()?->dark_mode ?? false);
@endphp
<body class="{{ $isDarkMode ? 'theme-dark' : 'theme-light' }} bg-[#f5f9fd] font-sans text-slate-700 antialiased">
    <div class="admin-shell">
        <x-admin.sidebar />
        <div class="admin-overlay" data-admin-overlay></div>
        <div class="admin-main">
            <x-admin.navbar />
            <main class="min-w-0">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        const sidebar = document.querySelector('.admin-sidebar');
        const overlay = document.querySelector('[data-admin-overlay]');
        const menuButton = document.querySelector('[data-admin-menu]');

        const closeSidebar = () => {
            sidebar?.classList.remove('is-open');
            overlay?.classList.remove('is-visible');
        };

        menuButton?.addEventListener('click', () => {
            sidebar?.classList.toggle('is-open');
            overlay?.classList.toggle('is-visible');
        });
        overlay?.addEventListener('click', closeSidebar);
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) closeSidebar();
        });
    </script>
    @stack('scripts')
</body>
</html>
