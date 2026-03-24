<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="IKM Juara - Platform akselerasi industri lokal Kota Madiun menuju pasar global. Integrasi Konsultasi Mandiri untuk produktivitas industri.">
    <title>IKM Juara - Akselerasi Industri Lokal</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-text {
            background: linear-gradient(90deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-card {
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            animation: float 6s ease-in-out infinite;
        }
        html { scroll-behavior: smooth; }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        /* Optimalisasi transisi menu mobile */
        #mobile-menu {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-slate-50 overflow-x-hidden">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="flex justify-between items-center px-6 lg:px-12 py-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('logo-ikm.png') }}" alt="Logo" class="w-full object-contain">
                </div>
                <span class="text-2xl font-extrabold tracking-tight text-slate-800 uppercase">
                    IKM<span class="text-yellow-500">JUARA</span>
                </span>
            </div>
            
            <div class="hidden md:flex items-center gap-10 font-bold text-sm tracking-wider text-slate-600">
                <a href="#" class="hover:text-indigo-600 transition">PROFIL</a>
                <a href="{{ route('daftar') }}" class="hover:text-indigo-600 transition">PENDAFTARAN</a>
                <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-200 hover:scale-105 transition active:scale-95 text-center">
                    AKSES DATA IKM
                </a>
            </div>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-slate-800 focus:outline-none p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                <
                /button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 px-6 py-6 space-y-4 shadow-xl">
            <a href="#" class="block font-bold text-slate-600 hover:text-indigo-600 py-2">PROFIL</a>
            <hr class="border-slate-50">
            <a href="/daftar" class="block font-bold text-slate-600 hover:text-indigo-600 py-2">PENDAFTARAN</a>
            <hr class="border-slate-50">
            <a href="{{ route('login') }}" class="block w-full bg-indigo-600 text-white px-6 py-4 rounded-xl font-bold shadow-lg text-center">
                AKSES DATA IKM
            </a>
        </div>
    </nav>

    <section class="relative min-h-[calc(100vh-80px)] flex items-center px-6 lg:px-24 py-12">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold text-green-700 tracking-[0.2em] uppercase">Sistem Aktif: IKM Juara V1.0</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                    Akselerasi <br> Industri <br> <span class="gradient-text">Lokal ke Global.</span>
                </h1>
                <div class="bg-white p-6 rounded-2xl border-l-4 border-indigo-500 shadow-sm max-w-md">
                    <p class="text-slate-500 italic leading-relaxed text-lg">"Mendorong efisiensi dan jaminan usaha industri Kota Madiun."</p>
                </div>
                <div class="flex flex-wrap items-center gap-8">
<a href="{{ route('daftar') }}" 
   class="group inline-flex items-center gap-3 bg-slate-900 text-white px-8 py-5 rounded-2xl text-lg font-bold hover:bg-indigo-700 transition-all duration-300 shadow-2xl">
    MULAI DAFTAR SEKARANG
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
    </svg>
</a>
                    <div class="flex items-center">
                        <div class="flex -space-x-3 mr-4">
                            <img class="w-12 h-12 rounded-full border-4 border-white" src="https://i.pravatar.cc/100?u=1" alt="user">
                            <img class="w-12 h-12 rounded-full border-4 border-white" src="https://i.pravatar.cc/100?u=2" alt="user">
                            <img class="w-12 h-12 rounded-full border-4 border-white" src="https://i.pravatar.cc/100?u=3" alt="user">
                            <div class="w-12 h-12 rounded-full bg-slate-200 border-4 border-white flex items-center justify-center text-xs font-bold text-slate-600">+{{ $totalIkm }}</div>
                        </div>
                        <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">IKM Terdaftar</span>
                    </div>
                </div>
            </div>
            <div class="relative flex justify-center lg:justify-end">
                <div class="hero-card bg-white p-10 lg:p-16 rounded-[60px] w-full max-w-lg flex flex-col items-center text-center border border-slate-100 relative z-10">
                    <div class="w-40 h-40 mb-10 flex items-center justify-center">
                        <img src="{{ asset('logo-ikm.png') }}" alt="Logo Center" class="w-full object-contain">
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-800 italic mb-6 tracking-tighter uppercase">IKM JUARA</h2>
                    <p class="text-slate-400 text-sm leading-relaxed px-4 font-semibold">( Integrasi Konsultasi Mandiri untuk Jaminan Usaha, Akselerasi, dan Produktivitas Industri Anda! )</p>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] bg-gradient-to-tr from-indigo-200/40 to-transparent rounded-full blur-[100px] -z-0"></div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6 lg:px-24">
            <div class="text-center mb-16 space-y-4">
                <h3 class="text-indigo-600 font-bold tracking-widest uppercase text-sm">Keunggulan Kami</h3>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900">3 Pilar Utama IKM Juara</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Kami hadir dengan ekosistem digital yang dirancang khusus untuk mempercepat pertumbuhan industri kreatif di Kota Madiun.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.75c-3.235-1.554-5.618-4.904-5.618-8.75V11h11.236v2c0 3.846-2.383 7.196-5.618 8.75z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mb-4">Jaminan Usaha</h4>
                    <p class="text-slate-500 leading-relaxed">Memberikan perlindungan hukum, sertifikasi, dan standarisasi kualitas agar produk Anda dipercaya oleh pasar luas.</p>
                </div>
                <div class="group p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-purple-600 transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mb-4">Akselerasi</h4>
                    <p class="text-slate-500 leading-relaxed">Mempercepat penetrasi pasar melalui digital marketing, akses modal, dan jaringan distribusi Global yang terintegrasi.</p>
                </div>
                <div class="group p-10 rounded-[40px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-yellow-500 transition-colors duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mb-4">Produktivitas</h4>
                    <p class="text-slate-500 leading-relaxed">Optimasi proses produksi melalui konsultasi mandiri dan teknologi tepat guna demi efisiensi biaya yang maksimal.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6 lg:px-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <h3 class="text-indigo-600 font-bold tracking-widest uppercase text-sm">Data Real-Time</h3>
                    <h2 class="text-4xl font-extrabold text-slate-900 leading-tight">Pertumbuhan IKM <br> di Kota Madiun</h2>
                    <p class="text-slate-500 text-lg leading-relaxed">Pantau distribusi industri kecil menengah di setiap wilayah. Data ini membantu pemerintah dalam mengambil kebijakan yang tepat sasaran untuk akselerasi ekonomi lokal.</p>
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                            <span class="block text-3xl font-bold text-slate-800">3</span>
                            <span class="text-sm text-slate-400 font-medium">Kecamatan Utama</span>
                        </div>
                        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                            <span class="block text-3xl font-bold text-indigo-600">{{ $totalIkm }}+</span>
                            <span class="text-sm text-slate-400 font-medium">IKM Terverifikasi</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-[40px] shadow-2xl shadow-indigo-100/50 border border-slate-100">
                    <div class="relative h-[300px]">
                        <canvas id="ikmChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white pt-20 pb-10">
        <div class="container mx-auto px-6 lg:px-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-extrabold tracking-tight">IKM<span class="text-yellow-500">JUARA</span></span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">Akselerasi Industri Lokal Madiun menuju pasar Global. Di bawah naungan Dinas Tenaga Kerja, Koperasi Usaha Kecil dan Menengah Kota Madiun.</p>
                    <div class="space-y-3">
                        <h4 class="font-bold text-white uppercase text-xs tracking-widest">Alamat Kantor</h4>
                        <p class="text-slate-400 text-sm italic">Jl. Bolodewo No.8, Kartoharjo, Kec. Kartoharjo, Kota Madiun, Jawa Timur 63117</p>
                        <div class="rounded-2xl overflow-hidden h-32 mt-4 grayscale opacity-70 hover:grayscale-0 hover:opacity-100 transition duration-500">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.5518465430883!2d111.5358!3d-7.62!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMzcnMTIuMCJTIDExMcKwMzInMDguOCJF!5e0!3m2!1sid!2sid!4v1650000000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <h4 class="font-bold text-white uppercase text-xs tracking-widest border-l-2 border-yellow-500 pl-3">Navigasi</h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Profil Dinas</a></li>
                        <li><a href="#" class="hover:text-white transition">Alur Pendaftaran IKM</a></li>
                        <li><a href="#" class="hover:text-white transition">Layanan Sertifikasi</a></li>
                        <li><a href="#" class="hover:text-white transition">Direktori Produk Lokal</a></li>
                    </ul>
                </div>
                <div class="space-y-6">
                    <h4 class="font-bold text-white uppercase text-xs tracking-widest border-l-2 border-indigo-500 pl-3">Statistik Website</h4>
                    <div class="bg-slate-800/50 p-6 rounded-2xl space-y-4 border border-slate-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-slate-400">Total Kunjungan</span>
                            <span class="text-lg font-bold text-indigo-400">12,840</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-slate-400">Pengunjung Aktif</span>
                            <span class="text-lg font-bold text-green-400">42</span>
                        </div>
                        <div class="pt-2 border-t border-slate-700">
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter italic">
                                Terakhir diperbarui: {{ \Carbon\Carbon::parse($terakhirUpdate)->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <h4 class="font-bold text-white uppercase text-xs tracking-widest border-l-2 border-purple-500 pl-3">Kontak Kami</h4>
                    <ul class="space-y-4 text-slate-400 text-sm">
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            (0351) 454288
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            disnaker@madiunkota.go.id
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-xs font-medium">
                <p>© 2026 Pemerintah Kota Madiun. All rights reserved. / Developed by Bidang Perindustrian.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Script Mobile Menu
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                menu.classList.add('hidden');
            }
        });

        // 2. Script Chart.js dengan Data Dinamis dari Controller
        const ctx = document.getElementById('ikmChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 1)'); 
        gradient.addColorStop(1, 'rgba(168, 85, 247, 0.2)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Kartoharjo', 'Manguharjo', 'Taman'],
                datasets: [{
                    label: 'Jumlah IKM',
                    // Data diambil langsung dari PHP Controller
                    data: [
                        {{ $dataChart['Kartoharjo'] }}, 
                        {{ $dataChart['Manguharjo'] }}, 
                        {{ $dataChart['Taman'] }}
                    ],
                    backgroundColor: gradient,
                    borderRadius: 12,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', weight: 'bold' } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans', weight: 'bold' } }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    </script>
</body>
</html>