@extends('layouts.admin')

@section('title', 'Ringkasan Data')

@section('content')
<div class="space-y-8">
    {{-- Baris Card Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:shadow-slate-200/50 group">
            <div class="flex justify-between items-start mb-6">
                <div class="p-4 bg-orange-50 rounded-2xl text-orange-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Database IKM</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-2">Total Pelaku Usaha</p>
            <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
                {{-- Menggunakan tabel pelaku_usaha yang sudah pasti ada --}}
                {{ DB::table('pelaku_usaha')->count() }} 
                <span class="text-sm text-slate-300 font-medium ml-1 italic text-orange-400">Unit</span>
            </h3>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:shadow-slate-200/50 group">
            <div class="flex justify-between items-start mb-6">
                <div class="p-4 bg-indigo-50 rounded-2xl text-indigo-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">User System</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-2">Total Admin</p>
            <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
                {{ DB::table('users')->count() }} 
                <span class="text-sm text-slate-300 font-medium ml-1 italic text-indigo-400">User</span>
            </h3>
        </div>

        <div class="bg-[#0F172A] p-8 rounded-[2.5rem] shadow-2xl shadow-slate-300 transition-all group relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-6">
                    <div class="p-4 bg-slate-800 rounded-2xl text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mb-2">Status Koneksi</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Online</h3>
                    <span class="text-[10px] font-bold text-emerald-500 animate-bounce">SECURE</span>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-slate-800/50 rounded-full blur-3xl"></div>
        </div>
    </div>

    {{-- Area Visual --}}
    <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-sm min-h-[400px] flex flex-col items-center justify-center text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 via-indigo-500 to-purple-500"></div>
        
        <div class="bg-slate-50 p-6 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
            </svg>
        </div>
        
        <h4 class="text-2xl font-extrabold text-slate-800 mb-2">Visualisasi Grafik IKM</h4>
        <p class="text-slate-400 max-w-md mx-auto leading-relaxed">
            Data statistik akan tampil secara otomatis di sini setelah data kecamatan diperbarui di menu 
            <a href="{{ route('admin.statistik') }}" class="text-indigo-600 font-bold hover:underline">Statistik</a>.
        </p>
    </div>
</div>
@endsection