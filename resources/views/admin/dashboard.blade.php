<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">
    <div class="min-h-screen">
        <h1 class="p-8 text-2xl font-bold">Admin Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}" class="px-8">
            @csrf
            <button type="submit" class="rounded-lg bg-red-500 px-4 py-2 text-white">Logout</button>
        </form>
    </div>
</body>
</html>
