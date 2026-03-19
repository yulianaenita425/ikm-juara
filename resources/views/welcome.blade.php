<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IKM Juara - Akselerasi Industri Lokal</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .gradient-text {
            background: linear-gradient(90deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-card {
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-slate-50 overflow-x-hidden">

    <nav class="flex justify-between items-center px-6 lg:px-12 py-6 bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
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
            <a href="#" class="hover:text-indigo-600 transition">PENDAFTARAN</a>
            <button class="bg-indigo-600 text-white px-6 py-3 rounded-2xl shadow-lg shadow-indigo-200 hover:scale-105 transition active:scale-95">
                AKSES DATA IKM
            </button>
        </div>
    </nav>

    <section class="relative min-h-[calc(100vh-80px)] flex items-center px-6 lg:px-24 py-12">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="space-y-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-bold text-green-700 tracking-[0.2em] uppercase">System Active: IKM Juara V2.0</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                    Akselerasi <br>
                    Industri <br>
                    <span class="gradient-text">Lokal ke Global.</span>
                </h1>

                <div class="bg-white p-6 rounded-2xl border-l-4 border-indigo-500 shadow-sm max-w-md">
                    <p class="text-slate-500 italic leading-relaxed text-lg">
                        "Mendorong efisiensi dan jaminan usaha industri Kota Madiun."
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-8">
                    <button class="group flex items-center gap-3 bg-slate-900 text-white px-8 py-5 rounded-2xl text-lg font-bold hover:bg-indigo-700 transition-all duration-300 shadow-2xl">
                        MULAI DAFTAR SEKARANG
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                    
                    <div class="flex items-center">
                        <div class="flex -space-x-3 mr-4">
                            <img class="w-12 h-12 rounded-full border-4 border-white" src="https://i.pravatar.cc/100?u=1" alt="user">
                            <img class="w-12 h-12 rounded-full border-4 border-white" src="https://i.pravatar.cc/100?u=2" alt="user">
                            <img class="w-12 h-12 rounded-full border-4 border-white" src="https://i.pravatar.cc/100?u=3" alt="user">
                            <div class="w-12 h-12 rounded-full bg-slate-200 border-4 border-white flex items-center justify-center text-xs font-bold text-slate-600">+500</div>
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
                    <p class="text-slate-400 text-sm leading-relaxed px-4 font-semibold">
                        ( Integrasi Konsultasi Mandiri untuk Jaminan Usaha, Akselerasi, dan Produktivitas Industri Anda! )
                    </p>
                </div>
                
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[110%] h-[110%] bg-gradient-to-tr from-indigo-200/40 to-transparent rounded-full blur-[100px] -z-0"></div>
            </div>

        </div>
    </section>

</body>
</html>