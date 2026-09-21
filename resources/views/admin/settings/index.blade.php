@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="min-h-[calc(100vh-4rem)] bg-gray-50/50 px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl">
        <header class="mb-6">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Settings</h1>
            <p class="mt-1 text-sm text-slate-400">Kelola informasi akun, keamanan, dan pengaturan website Anda.</p>
        </header>

        <div class="grid gap-4 md:grid-cols-[190px_minmax(0,1fr)] lg:grid-cols-[230px_minmax(0,1fr)] lg:gap-6">
            <aside class="h-fit rounded-2xl border border-gray-100 bg-white p-3 shadow-sm">
                <p class="px-3 pb-3 pt-2 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Pengaturan</p>
                <nav class="space-y-1" aria-label="Settings sections">
                    <button type="button" data-settings-tab="profile" class="settings-tab flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold transition-all duration-200 hover:bg-gray-100">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600"><i class="bi bi-person"></i></span>
                        <span class="flex-1">Profile Admin</span><i class="bi bi-chevron-right text-xs"></i>
                    </button>
                    <button type="button" data-settings-tab="password" class="settings-tab flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold transition-all duration-200 hover:bg-gray-100">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600"><i class="bi bi-shield-lock"></i></span>
                        <span class="flex-1">Change Password</span><i class="bi bi-chevron-right text-xs"></i>
                    </button>
                    <button type="button" data-settings-tab="company" class="settings-tab flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold transition-all duration-200 hover:bg-gray-100">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600"><i class="bi bi-building"></i></span>
                        <span class="flex-1">Company Profile</span><i class="bi bi-chevron-right text-xs"></i>
                    </button>
                    <button type="button" data-settings-tab="notification" class="settings-tab flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-semibold transition-all duration-200 hover:bg-gray-100">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50 text-violet-600"><i class="bi bi-bell"></i></span>
                        <span class="flex-1">Notifikasi Admin</span><i class="bi bi-chevron-right text-xs"></i>
                    </button>
                </nav>
            </aside>

            <section class="min-w-0 rounded-2xl border border-gray-100 bg-white p-5 shadow-sm sm:p-7">
                <form method="POST" action="{{ route('admin.settings.store') }}" data-settings-panel="profile" class="settings-panel">
                    @csrf
                    <input type="hidden" name="section" value="profile">
                    <div class="mb-7 border-b border-slate-100 pb-5"><h2 class="text-xl font-bold text-slate-900">Profile Admin</h2><p class="mt-1 text-sm text-slate-400">Informasi akun admin yang sedang login.</p></div>
                    <div class="space-y-5">
                        <div><label for="name" class="form-label">Nama Admin</label><input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-sky-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">@error('name')<p class="form-error">{{ $message }}</p>@enderror</div>
                        <div><label for="email" class="form-label">Email Admin</label><input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-sky-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">@error('email')<p class="form-error">{{ $message }}</p>@enderror</div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5"><a href="{{ route('admin.settings') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 hover:shadow-sm">Batal</a><button type="submit" class="inline-flex items-center rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.02] hover:bg-sky-600 hover:shadow-md"><i class="bi bi-floppy me-2"></i>Simpan Perubahan</button></div>
                </form>

                <form method="POST" action="{{ route('admin.settings.store') }}" data-settings-panel="password" class="settings-panel hidden">
                    @csrf
                    <input type="hidden" name="section" value="password">
                    <div class="mb-7 border-b border-slate-100 pb-5"><h2 class="text-xl font-bold text-slate-900">Change Password</h2><p class="mt-1 text-sm text-slate-400">Perbarui keamanan akun Anda.</p></div>
                    <div class="space-y-5">
                        <div><label for="current_password" class="form-label">Password Lama</label><input id="current_password" name="current_password" type="password" class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-amber-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" autocomplete="current-password">@error('current_password')<p class="form-error">{{ $message }}</p>@enderror</div>
                        <div><label for="password" class="form-label">Password Baru</label><input id="password" name="password" type="password" class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-amber-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" autocomplete="new-password">@error('password')<p class="form-error">{{ $message }}</p>@enderror</div>
                        <div><label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label><input id="password_confirmation" name="password_confirmation" type="password" class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-amber-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" autocomplete="new-password"></div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5"><a href="{{ route('admin.settings') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 hover:shadow-sm">Batal</a><button type="submit" class="inline-flex items-center rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.02] hover:bg-sky-600 hover:shadow-md"><i class="bi bi-key me-2"></i>Ubah Password</button></div>
                </form>

                <form method="POST" action="{{ route('admin.settings.store') }}" data-settings-panel="company" class="settings-panel hidden">
                    @csrf
                    <input type="hidden" name="section" value="company">
                    <div class="mb-7 border-b border-slate-100 pb-5"><h2 class="text-xl font-bold text-slate-900">Company Profile</h2><p class="mt-1 text-sm text-slate-400">Informasi bisnis yang tampil di website dan sistem.</p></div>
                    <div class="space-y-5">
                        <div><label for="company_name" class="form-label">Nama perusahaan</label><input id="company_name" name="company_name" type="text" value="{{ old('company_name', $user->company_name) }}" class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-emerald-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></div>
                        <div><label for="company_email" class="form-label">Email perusahaan</label><input id="company_email" name="company_email" type="email" value="{{ old('company_email', $user->company_email) }}" class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-emerald-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">@error('company_email')<p class="form-error">{{ $message }}</p>@enderror</div>
                        <div><label for="company_phone" class="form-label">Nomor telepon</label><input id="company_phone" name="company_phone" type="text" value="{{ old('company_phone', $user->company_phone) }}" class="form-input h-11 rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-emerald-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"></div>
                        <div><label for="company_address" class="form-label">Alamat</label><textarea id="company_address" name="company_address" rows="3" class="form-input rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-emerald-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('company_address', $user->company_address) }}</textarea></div>
                        <div><label for="company_description" class="form-label">Deskripsi singkat perusahaan</label><textarea id="company_description" name="company_description" rows="4" class="form-input rounded-xl border-slate-200 text-sm transition-all duration-200 hover:border-emerald-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('company_description', $user->company_description) }}</textarea></div>
                    </div>
                    <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5"><a href="{{ route('admin.settings') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 hover:shadow-sm">Batal</a><button type="submit" class="inline-flex items-center rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.02] hover:bg-sky-600 hover:shadow-md"><i class="bi bi-check-circle me-2"></i>Simpan Perubahan</button></div>
                </form>

                <form method="POST" action="{{ route('admin.settings.store') }}" data-settings-panel="notification" class="settings-panel hidden">
                    @csrf
                    <input type="hidden" name="section" value="notification">
                    <div class="mb-7 border-b border-slate-100 pb-5"><h2 class="text-xl font-bold text-slate-900">Notifikasi Admin</h2><p class="mt-1 text-sm text-slate-400">Atur notifikasi admin untuk aktivitas sistem.</p></div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 transition-colors duration-200 hover:border-sky-200 hover:bg-sky-50/40">
                        <label for="admin_notifications_enabled" class="flex cursor-pointer items-center justify-between gap-4"><div><p class="text-sm font-semibold text-slate-700">Aktifkan notifikasi admin</p><p class="mt-1 text-xs text-slate-500">Mengirimkan pemberitahuan saat ada aktivitas penting.</p></div><span class="relative inline-flex h-6 w-11 items-center"><input id="admin_notifications_enabled" name="admin_notifications_enabled" type="checkbox" value="1" @checked(old('admin_notifications_enabled', $user->admin_notifications_enabled ?? true)) class="peer sr-only"><span class="absolute inset-0 rounded-full bg-slate-200 transition peer-checked:bg-sky-500"></span><span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span></span></label>
                    </div>
                    <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5"><a href="{{ route('admin.settings') }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition-all duration-200 hover:-translate-y-0.5 hover:bg-gray-50 hover:shadow-sm">Batal</a><button type="submit" class="inline-flex items-center rounded-xl bg-sky-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:scale-[1.02] hover:bg-sky-600 hover:shadow-md"><i class="bi bi-bell-fill me-2"></i>Simpan Perubahan</button></div>
                </form>
            </section>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const settingsTabs = document.querySelectorAll('[data-settings-tab]');
    const settingsPanels = document.querySelectorAll('[data-settings-panel]');
    const activateSettingsTab = (tab) => {
        settingsTabs.forEach((button) => {
            const active = button.dataset.settingsTab === tab;
            button.classList.toggle('bg-blue-50', active);
            button.classList.toggle('text-blue-600', active);
            button.classList.toggle('text-slate-600', !active);
            button.classList.toggle('font-semibold', active);
            button.classList.toggle('font-medium', !active);
            button.querySelector('.bi-chevron-right')?.classList.toggle('opacity-0', !active);
        });
        settingsPanels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.settingsPanel !== tab));
        localStorage.setItem('settings-tab', tab);
    };
    settingsTabs.forEach((button) => button.addEventListener('click', () => activateSettingsTab(button.dataset.settingsTab)));
    activateSettingsTab(localStorage.getItem('settings-tab') || 'profile');
</script>
@endpush
@endsection
