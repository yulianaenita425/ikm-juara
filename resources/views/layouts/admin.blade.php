<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-blue-900 text-white p-6">
            <h1 class="text-xl font-bold mb-6">ADMIN PANEL</h1>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-blue-800 rounded">Dashboard</a>
                <a href="{{ route('admin.kegiatan.index') }}" class="block p-2 hover:bg-blue-800 rounded">Kegiatan</a>
                <a href="{{ route('admin.pendaftar') }}" class="block p-2 hover:bg-blue-800 rounded">Pendaftar</a>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow p-4 text-right">
                <span class="font-semibold">Administrator</span>
            </header>
            <div class="p-4">
                @yield('content') {{-- Bagian penting untuk menampung isi halaman --}}
            </div>
        </main>
    </div>
</body>
</html>