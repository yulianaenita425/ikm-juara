<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKMJUARA - Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen">
<aside class="w-80 bg-[#0F172A] text-white p-8 flex flex-col fixed h-full shadow-2xl">
    <div class="mb-12">
        <h1 class="text-2xl font-bold tracking-tight italic">IKM<span class="text-orange-500">JUARA</span></h1>
        <p class="text-[10px] text-slate-500 tracking-[0.3em] font-bold uppercase mt-1">Control Panel</p>
    </div>

    <nav class="space-y-3 flex-1">
        <a href="{{ url('admin/dashboard') }}" 
           class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/dashboard*') ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ request()->is('admin/dashboard*') ? 'text-orange-400' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="font-bold text-[15px]">Dashboard</span>
        </a>

        <a href="{{ route('admin.data-ikm') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/data-ikm*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            <span class="font-bold text-[15px]">Data Pelaku Usaha</span>
        </a>

        <a href="{{ route('admin.pendaftar') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/pendaftar*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            <span class="font-bold text-[15px]">Data Pendaftar</span>
        </a>

        <a href="{{ url('admin/statistik') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/statistik*') ? 'bg-slate-800 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            <span class="font-bold text-[15px]">Statistik</span>
        </a>

<a href="{{ route('admin.publikasi') }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.publikasi') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-400 hover:bg-slate-50 hover:text-slate-700' }}">
    <div class="w-5 h-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25H5.625A2.25 2.25 0 0 1 3.375 18V4.5c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V7.5Z" />
        </svg>
    </div>
    <span class="font-medium">Publikasi</span>
</a>
        <div class="my-6 border-t border-slate-800/50"></div>

        <a href="{{ route('admin.pengaturan') }}" 
           class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/pengaturan*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
            <span class="font-bold text-[15px]">Pengaturan Admin</span>
        </a>
    </nav>

    <div class="mt-auto">
        <hr class="border-slate-800/50 mb-6">
        <a href="javascript:void(0)" onclick="handleLogout()" 
           class="flex items-center gap-4 p-4 rounded-2xl text-red-400 hover:bg-red-500/10 hover:text-red-500 transition-all font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500/50 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="text-[15px]">Keluar Akun</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>
        <main class="flex-1 ml-80">
            <header class="bg-white border-b border-slate-100 p-10 flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-extrabold text-slate-800">@yield('title', 'Ringkasan Data')</h2>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-2">
                        {{ strtoupper(\Carbon\Carbon::now()->translatedFormat('l, d F Y')) }}
                    </p>
                </div>
            </header>

            <div class="p-10">
                @yield('content')
            </div>
        </main>
    </div>
<script>
    function handleLogout() {
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: "Apakah Anda yakin ingin keluar dari Control Panel IKMJUARA?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Red-500
            cancelButtonColor: '#1e293b', // Slate-800
            confirmButtonText: 'Ya, Keluar Sekarang',
            cancelButtonText: 'Batal',
            borderRadius: '24px',
            background: '#ffffff',
            customClass: {
                title: 'font-bold text-slate-800',
                htmlContainer: 'text-slate-500 font-medium'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Notifikasi perpisahan singkat sebelum redirect
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Sesi Anda telah berakhir. Menuju halaman login...',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    borderRadius: '24px'
                });
                
                setTimeout(() => {
                    document.getElementById('logout-form').submit();
                }, 1500);
            }
        });
    }
</script>
</body>
</html>