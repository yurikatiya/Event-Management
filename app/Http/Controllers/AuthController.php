<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $legacyUsernameInput = $request->has('username') && ! $request->has('identifier');
        $identifier = $request->input('identifier', $request->input('username'));
        $request->merge(['identifier' => $identifier]);

        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'identifier.required' => 'Email/Username wajib diisi.',
        ]);

        $user = \App\Models\User::query()
            ->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'identifier' => 'Email/Username atau Password salah.',
            ])->withInput(['identifier' => $identifier]);
        }

        if ($user->role !== 'admin') {
            return back()->withErrors([
                'identifier' => 'Akun ini tidak memiliki akses admin.',
            ])->withInput(['identifier' => $identifier]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended($legacyUsernameInput ? '/admin/dashboard' : '/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
