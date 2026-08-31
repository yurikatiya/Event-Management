<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('admin.settings.index', [
            'user' => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $section = $request->input('section', 'profile');

        if ($section === 'password') {
            $validated = $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'current_password.required' => 'Password lama wajib diisi.',
                'password.required' => 'Password baru wajib diisi.',
                'password.min' => 'Password baru minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            ]);

            if (! Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
            }

            $user->update([
                'password' => $validated['password'],
            ]);

            return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
        }

        if ($section === 'company') {
            $validated = $request->validate([
                'company_name' => ['nullable', 'string', 'max:255'],
                'company_email' => ['nullable', 'email', 'max:255'],
                'company_phone' => ['nullable', 'string', 'max:50'],
                'company_address' => ['nullable', 'string', 'max:255'],
                'company_description' => ['nullable', 'string', 'max:1000'],
            ], [
                'company_email.email' => 'Email perusahaan harus valid.',
            ]);

            $user->update($validated);

            return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
        }

        if ($section === 'notification') {
            $validated = $request->validate([
                'admin_notifications_enabled' => ['nullable', 'boolean'],
                'dark_mode' => ['nullable', 'boolean'],
            ]);

            $user->update([
                'admin_notifications_enabled' => (bool) ($validated['admin_notifications_enabled'] ?? false),
                'dark_mode' => (bool) ($validated['dark_mode'] ?? false),
            ]);

            return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
        }

        if ($section === 'appearance') {
            $validated = $request->validate([
                'dark_mode' => ['nullable', 'boolean'],
            ]);

            $user->update([
                'dark_mode' => (bool) ($validated['dark_mode'] ?? false),
            ]);

            return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email admin wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
