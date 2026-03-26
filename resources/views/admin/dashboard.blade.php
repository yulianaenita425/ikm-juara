@extends('layouts.admin')

@section('title', 'Ringkasan Data')

@section('content')
<div class="space-y-8">
    {{-- Baris Card Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1: Total Kegiatan --}}
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group transition-all hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Data Program</span>
            </div>
<div>
    <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-1">Total Kegiatan</p>
    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
        {{ $totalKegiatan }} <span class="text-sm text-orange-400 font-medium ml-1 italic">Event</span>
    </h3>
</div>
        </div>

        {{-- Card 2: Total Pendaftar --}}
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group transition-all hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Peserta</span>
            </div>
<div>
    <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-1">Total Pendaftar</p>
    <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
        {{ $totalPendaftar }} <span class="text-sm text-emerald-400 font-medium ml-1 italic">Orang</span>
    </h3>
</div>
        </div>

        {{-- Card 3: Total Admin --}}
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden group transition-all hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">User System</span>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-1">Total Admin</p>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
                    {{ DB::table('users')->count() }} <span class="text-sm text-indigo-400 font-medium ml-1 italic">User</span>
                </h3>
            </div>
        </div>

        {{-- Card 4: Status Koneksi --}}
        <div class="bg-[#0F172A] p-8 rounded-[32px] shadow-2xl shadow-slate-300 transition-all group relative overflow-hidden">
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

    {{-- Area Grafik Sebaran --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
            <h4 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tight">Sebaran Pelaku Usaha / Kecamatan</h4>
            <canvas id="chartKecamatan" height="300"></canvas>
        </div>

        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
            <h4 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tight">Sebaran Pelaku Usaha / Kelurahan</h4>
            <canvas id="chartKelurahan" height="300"></canvas>
        </div>
    </div>

    {{-- Info Card Tambahan (Total IKM Unit) --}}
    <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-sm flex flex-col items-center justify-center text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 via-indigo-500 to-purple-500"></div>
        
        <div class="bg-slate-50 p-6 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        
        <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-2">Total Seluruh Pelaku Usaha Terdaftar</p>
        <h3 class="text-5xl font-black text-slate-800 tracking-tighter mb-4">
            {{ DB::table('pelaku_usaha')->count() }} 
            <span class="text-xl text-orange-400 font-medium italic">Unit Usaha</span>
        </h3>
        <p class="text-slate-400 max-w-md mx-auto leading-relaxed text-sm">
            Data statistik di atas disinkronkan secara real-time dengan database. Untuk detail lebih lanjut, kunjungi menu 
            <a href="{{ route('admin.data-ikm') }}" class="text-indigo-600 font-bold hover:underline"><span>Data Pelaku usaha</span></a>.
        </p>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Kecamatan (Bar)
    const ctxKec = document.getElementById('chartKecamatan').getContext('2d');
    new Chart(ctxKec, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dataKecamatan->pluck('kecamatan')) !!},
            datasets: [{
                label: 'Jumlah Pelaku Usaha',
                data: {!! json_encode($dataKecamatan->pluck('total')) !!},
                backgroundColor: '#6366f1',
                borderRadius: 12,
            }]
        },
        options: { 
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Grafik Kelurahan (Line)
    const ctxKel = document.getElementById('chartKelurahan').getContext('2d');
    new Chart(ctxKel, {
        type: 'line',
        data: {
            labels: {!! json_encode($Kelurahan->pluck('kelurahan')) !!},
            datasets: [{
                label: 'Jumlah Pelaku Usaha',
                data: {!! json_encode($Kelurahan->pluck('total')) !!},
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#f59e0b'
            }]
        },
        options: { 
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection