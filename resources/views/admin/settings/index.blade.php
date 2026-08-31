@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-slate-50 px-5 py-8 sm:px-8 lg:px-10" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="mx-auto max-w-6xl">
        <header class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Settings</h1>
            <p class="mt-1 text-base text-slate-400">Kelola informasi akun, keamanan, dan pengaturan website Anda.</p>
        </header>

        @if (session('success'))
            <div class="mb-6"><x-admin.alert>{{ session('success') }}</x-admin.alert></div>
        @endif

        @if (session('error'))
            <div class="mb-6"><x-admin.alert type="error">{{ session('error') }}</x-admin.alert></div>
        @endif

        <div class="grid gap-6 xl:grid-cols-2">
            <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="section" value="profile">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-600"><i class="bi bi-person-badge"></i></span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Profile Admin</h2>
                            <p class="text-sm text-slate-400">Informasi akun admin yang sedang login.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="name" class="form-label">Nama Admin</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="form-label">Email Admin</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-600">
                                <i class="bi bi-floppy me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="section" value="password">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600"><i class="bi bi-shield-lock"></i></span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Change Password</h2>
                            <p class="text-sm text-slate-400">Perbarui keamanan akun Anda.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="form-label">Password Lama</label>
                            <input id="current_password" name="current_password" type="password" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" autocomplete="current-password">
                            @error('current_password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="form-label">Password Baru</label>
                            <input id="password" name="password" type="password" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" autocomplete="new-password">
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400" autocomplete="new-password">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">
                                <i class="bi bi-key me-2"></i>
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 grid gap-6 xl:grid-cols-2">
            <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="section" value="company">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600"><i class="bi bi-building"></i></span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Website / Company Settings</h2>
                            <p class="text-sm text-slate-400">Informasi bisnis yang tampil di website dan sistem.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="company_name" class="form-label">Nama perusahaan</label>
                            <input id="company_name" name="company_name" type="text" value="{{ old('company_name', $user->company_name) }}" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                        </div>

                        <div>
                            <label for="company_email" class="form-label">Email perusahaan</label>
                            <input id="company_email" name="company_email" type="email" value="{{ old('company_email', $user->company_email) }}" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                            @error('company_email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="company_phone" class="form-label">Nomor telepon</label>
                            <input id="company_phone" name="company_phone" type="text" value="{{ old('company_phone', $user->company_phone) }}" class="form-input h-11 rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">
                        </div>

                        <div>
                            <label for="company_address" class="form-label">Alamat</label>
                            <textarea id="company_address" name="company_address" rows="3" class="form-input rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">{{ old('company_address', $user->company_address) }}</textarea>
                        </div>

                        <div>
                            <label for="company_description" class="form-label">Deskripsi singkat perusahaan</label>
                            <textarea id="company_description" name="company_description" rows="4" class="form-input rounded-xl border-slate-200 text-sm focus:border-sky-400 focus:ring-2 focus:ring-sky-400">{{ old('company_description', $user->company_description) }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-600">
                                <i class="bi bi-check-circle me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.settings.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="section" value="notification">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600"><i class="bi bi-bell"></i></span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800">Notification Settings</h2>
                            <p class="text-sm text-slate-400">Atur notifikasi admin untuk aktivitas sistem.</p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <label for="admin_notifications_enabled" class="flex cursor-pointer items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Aktifkan notifikasi admin</p>
                                <p class="mt-1 text-xs text-slate-500">Mengirimkan pemberitahuan saat ada aktivitas penting.</p>
                            </div>
                            <span class="relative inline-flex h-6 w-11 items-center">
                                <input id="admin_notifications_enabled" name="admin_notifications_enabled" type="checkbox" value="1" @checked(old('admin_notifications_enabled', $user->admin_notifications_enabled ?? true)) class="peer sr-only">
                                <span class="absolute inset-0 rounded-full bg-slate-200 transition peer-checked:bg-sky-500"></span>
                                <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                            </span>
                        </label>
                    </div>

                    <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <label for="dark_mode" class="flex cursor-pointer items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Dark mode</p>
                                <p class="mt-1 text-xs text-slate-500">Aktifkan tampilan gelap pada dashboard admin.</p>
                            </div>
                            <span class="relative inline-flex h-6 w-11 items-center">
                                <input id="dark_mode" name="dark_mode" type="checkbox" value="1" @checked(old('dark_mode', $user->dark_mode ?? false)) class="peer sr-only">
                                <span class="absolute inset-0 rounded-full bg-slate-200 transition peer-checked:bg-sky-500"></span>
                                <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                            </span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-violet-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-violet-600">
                            <i class="bi bi-bell-fill me-2"></i>
                            Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
