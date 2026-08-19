<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - R27 Creative Agency</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 px-5 py-10 text-slate-800">
    <main class="mx-auto max-w-md rounded-2xl bg-white p-8 shadow-xl shadow-slate-200/60">
        <a href="{{ url('/') }}" class="text-sm font-semibold text-[#008fd4]">R27 Creative Agency</a>
        <h1 class="mt-8 text-3xl font-bold text-slate-950">Create your account</h1>
        <p class="mt-2 text-sm text-slate-500">Daftar untuk mulai terhubung dengan event R27.</p>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
            @csrf
            @foreach ([
                ['name', 'Nama Lengkap', 'text'],
                ['username', 'Username', 'text'],
                ['email', 'Email', 'email'],
            ] as [$field, $label, $type])
                <div>
                    <label for="{{ $field }}" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">{{ $label }}</label>
                    <input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field) }}" required
                           class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm focus:border-[#00a1ee] focus:outline-none">
                    @error($field)<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            @endforeach

            <div>
                <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Password</label>
                <input id="password" name="password" type="password" required
                       class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm focus:border-[#00a1ee] focus:outline-none">
                @error('password')<p class="mt-2 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm focus:border-[#00a1ee] focus:outline-none">
            </div>

            <button type="submit" class="w-full rounded-xl bg-[#00a1ee] px-5 py-3 font-semibold text-white transition hover:bg-[#008fd4]">Sign Up</button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-500">Sudah memiliki akun? <a href="{{ route('login') }}" class="font-semibold text-[#008fd4]">Sign In</a></p>
    </main>
</body>
</html>