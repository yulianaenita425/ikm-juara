<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKMJUARA - Control Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen">
        <aside class="w-80 bg-[#0F172A] text-white p-8 flex flex-col fixed h-full">
            <div class="mb-12">
                <h1 class="text-2xl font-bold tracking-tight italic">IKM<span class="text-orange-500">JUARA</span></h1>
                <p class="text-[10px] text-slate-500 tracking-[0.3em] font-bold uppercase mt-1">Control Panel</p>
            </div>

            <nav class="space-y-3 flex-1">
                <a href="{{ url('admin/dashboard') }}" 
   class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/dashboard*') ? 'bg-slate-800 text-white shadow-lg shadow-black/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ request()->is('admin/dashboard*') ? 'text-orange-400' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
    </svg>
    <span class="font-bold text-[15px]">Dashboard</span>
</a>
                <a href="{{ route('admin.data-ikm') }}" 
                   class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/data-ikm*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="font-bold text-[15px]">Data Pelaku Usaha</span>
                </a>

                <a href="{{ route('admin.pendaftar') }}" 
                   class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/pendaftar*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-bold text-[15px]">Data Pendaftar</span>
                </a>

<a href="{{ url('admin/statistik') }}" 
   class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/statistik*') ? 'bg-slate-800 text-white shadow-lg shadow-black/20' : 'text-slate-400 hover:bg-slate-800/50' }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ request()->is('admin/statistik*') ? 'text-orange-400' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
    </svg>
    <span class="font-bold text-[15px]">Statistik</span>
</a>

                <div class="my-6 border-t border-slate-800/50"></div>

                <a href="{{ route('admin.pengaturan') }}" 
                   class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ request()->is('admin/pengaturan*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                    <span class="font-bold text-[15px]">Pengaturan Admin</span>
                </a>
            </nav>
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
</body>
</html>