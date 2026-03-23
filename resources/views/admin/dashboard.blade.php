<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - IKM Juara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; /* Slate 50 - Sangat lembut di mata */
        }
        .sidebar-navy {
            background-color: #0f172a; /* Navy sangat gelap (Slate 900) */
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="flex">

    <aside class="w-72 min-h-screen sidebar-navy text-slate-300 p-8 hidden lg:flex flex-col">
        <div class="mb-12">
            <h2 class="text-2xl font-black italic tracking-tighter text-white uppercase">
                IKM<span class="text-amber-500">JUARA</span>
            </h2>
            <p class="text-[10px] font-bold tracking-[0.3em] text-slate-500 mt-1 uppercase">Control Panel</p>
        </div>

        <nav class="space-y-4 flex-1">
            <a href="#" class="flex items-center gap-3 bg-slate-800 text-white px-5 py-4 rounded-2xl font-semibold transition shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
            <a href="/admin/data-ikm" class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-slate-800 transition font-medium group text-slate-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                Data Pelaku Usaha
            </a>
            <a href="{{ route('admin.pendaftar') }}" class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-slate-800 transition font-medium group text-slate-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Data Pendaftar
            </a>
            <a href="#" class="flex items-center gap-3 px-5 py-4 rounded-2xl hover:bg-slate-800 transition font-medium text-slate-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Statistik
            </a>
        </nav>

        <div class="pt-10 border-t border-slate-800">
            <a href="/" class="flex items-center gap-3 px-5 py-4 rounded-2xl text-red-400 hover:bg-red-500/10 transition font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Keluar
            </a>
        </div>
    </aside>

    <main class="flex-1 min-h-screen">
        <header class="bg-white border-b border-slate-200 px-10 py-6 flex justify-between items-center sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Ringkasan Data</h1>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kamis, 19 Maret 2026</p>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex flex-col text-right">
                    <span class="text-sm font-bold text-slate-700 uppercase">Administrator</span>
                    <span class="text-[10px] text-green-500 font-black">ACTIVE SESSION</span>
                </div>
                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center border border-slate-200 shadow-sm font-bold text-indigo-600">
                    AD
                </div>
            </div>
        </header>

        <div class="p-10 space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-[32px] card-shadow border border-slate-100 group hover:border-indigo-500 transition duration-300">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Total Industri</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black text-slate-800 tracking-tighter">512</h3>
                        <span class="bg-green-50 text-green-600 text-[10px] font-bold px-3 py-1 rounded-full mb-2">+12%</span>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-[32px] card-shadow border border-slate-100 group hover:border-amber-500 transition duration-300">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Pending Review</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black text-slate-800 tracking-tighter">24</h3>
                        <span class="bg-amber-50 text-amber-600 text-[10px] font-bold px-3 py-1 rounded-full mb-2">Perlu Tindakan</span>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-[32px] card-shadow border border-slate-100 group hover:border-indigo-500 transition duration-300">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Kunjungan Web</p>
                    <div class="flex items-end justify-between">
                        <h3 class="text-5xl font-black text-slate-800 tracking-tighter">1.2k</h3>
                        <span class="bg-indigo-50 text-indigo-600 text-[10px] font-bold px-3 py-1 rounded-full mb-2">Hari Ini</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[40px] border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-white">
                    <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Pendaftar IKM Terbaru</h3>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">Filter Data</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                                <th class="px-8 py-6 uppercase">ID</th>
                                <th class="px-8 py-6">Pemilik</th>
                                <th class="px-8 py-6">Nama Usaha</th>
                                <th class="px-8 py-6">Kecamatan</th>
                                <th class="px-8 py-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-semibold text-slate-600">
                            <tr class="border-b border-slate-50 hover:bg-slate-50/80 transition duration-200">
                                <td class="px-8 py-6 text-xs text-slate-400">#001</td>
                                <td class="px-8 py-6 text-slate-800">Budi Santoso</td>
                                <td class="px-8 py-6 italic">Sambel Pecel Juara</td>
                                <td class="px-8 py-6 font-bold text-xs uppercase tracking-wider">Kartoharjo</td>
                                <td class="px-8 py-6 flex justify-center gap-2">
                                    <button class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-indigo-600 hover:text-white transition uppercase">Detail</button>
                                    <button class="bg-green-50 text-green-600 px-4 py-2 rounded-xl text-xs font-black hover:bg-green-600 hover:text-white transition uppercase">Verifikasi</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>