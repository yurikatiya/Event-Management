<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login | PT R27 Creative Agency</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.12)] lg:grid-cols-[1.1fr_0.9fr]">
                <div class="relative hidden overflow-hidden bg-gradient-to-br from-blue-900 via-blue-700 to-blue-600 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.18),_transparent_40%)]"></div>
                    <div class="relative z-10">
                        <x-logo />
                    </div>

                    <div class="relative z-10 space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-3 py-1 text-xs font-medium text-blue-50 backdrop-blur-sm">
                            <span class="h-2 w-2 rounded-full bg-red-400"></span>
                            Internal Portal
                        </div>
                        <h1 class="max-w-sm text-3xl font-semibold leading-tight">
                            Sistem Manajemen Event
                        </h1>
                        <p class="max-w-md text-sm text-blue-100/90">
                            Platform internal PT R27 Creative Agency untuk mengelola event, sponsor, peserta, registrasi, dan approval pengajuan secara terstruktur.
                        </p>
                    </div>

                    <div class="relative z-10 flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-4 py-3 backdrop-blur-sm">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-blue-100">Status</p>
                            <p class="mt-1 text-lg font-semibold">Portal aktif</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-500/20 text-base font-bold text-red-200">
                            24/7
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="mb-8 flex items-center justify-between gap-4">
                        <div class="lg:hidden">
                            <x-logo />
                        </div>
                        <div class="ml-auto rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                            Admin & Participant
                        </div>
                    </div>

                    <div class="mb-8">
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-600">Welcome back</p>
                        <h2 class="mt-3 text-3xl font-bold text-slate-900">Login</h2>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="username" class="mb-2 block text-sm font-medium text-slate-700">Username</label>
                            <input
                                id="username"
                                name="username"
                                type="text"
                                value="{{ old('username') }}"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                                placeholder="Masukkan username"
                                required
                            />
                            @error('username')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                                placeholder="Masukkan password"
                                required
                            />
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end text-sm text-slate-600">
                            <span class="text-red-500">Security protected</span>
                        </div>

                        <button type="submit" class="flex w-full items-center justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">
                            Masuk ke Dashboard
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
