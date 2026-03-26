<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alur Pendaftaran Pelatihan - IKM JUARA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .step-line { position: absolute; left: 28px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; z-index: 0; }
        
        /* Animasi 3D Ringan */
        .card-3d { transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-style: preserve-3d; }
        .card-3d:hover { transform: translateY(-10px) rotateX(5deg) rotateY(2deg); }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="sticky top-0 z-50 glass border-b border-slate-200 py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <span class="font-black text-2xl tracking-tighter uppercase">IKM<span class="text-indigo-600">JUARA</span></span>
            </a>
            <a href="/" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                BERANDA
            </a>
        </div>
    </nav>

    <section class="py-20 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-indigo-50/50 skew-x-12 translate-x-20"></div>
        <div class="container mx-auto px-6 relative z-10 text-center md:text-left">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold tracking-widest uppercase mb-6">PANDUAN PESERTA</span>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 leading-tight">Alur Pendaftaran <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Pelatihan IKM</span></h1>
            <p class="text-slate-500 text-lg max-w-2xl mb-10 font-medium">Ikuti 6 langkah mudah berikut untuk menjadi bagian dari program pengembangan ekonomi kreatif di Kota Madiun. Estimasi pengisian: <strong class="text-slate-900">2-3 menit</strong>.</p>
        </div>
    </section>

    <section class="py-20 relative">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="relative">
                <div class="step-line hidden md:block"></div>

                <div class="space-y-16">
                    
                    <div class="relative pl-0 md:pl-20 group">
                        <div class="absolute left-0 top-0 w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-black text-xl z-10 shadow-lg shadow-indigo-200 transition-transform group-hover:scale-110">1</div>
                        <div class="card-3d bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                            <div class="absolute top-[-20px] right-[-20px] text-8xl opacity-10 grayscale group-hover:grayscale-0 transition-all duration-500">🎯</div>
                            <h3 class="text-2xl font-black mb-4">Pilih Kegiatan</h3>
                            <p class="text-slate-500 mb-6 font-medium">Cari dan pilih pelatihan yang paling relevan dengan kebutuhan bisnis Anda saat ini.</p>
                            <div class="grid grid-cols-2 gap-4 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div> Jadwal</div>
                                <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div> Lokasi</div>
                                <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div> Kuota</div>
                                <div class="flex items-center gap-2"><div class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></div> Deskripsi</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative pl-0 md:pl-20 group">
                        <div class="absolute left-0 top-0 w-14 h-14 bg-white text-indigo-600 border-2 border-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl z-10 shadow-lg transition-transform group-hover:scale-110">2</div>
                        <div class="card-3d bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                            <div class="absolute top-[-20px] right-[-20px] text-8xl opacity-10 grayscale group-hover:grayscale-0 transition-all duration-500">👤</div>
                            <h3 class="text-2xl font-black mb-4">Isi Data Diri</h3>
                            <p class="text-slate-500 mb-6 font-medium">Validasi identitas peserta untuk keperluan sertifikat dan administrasi resmi pemerintah.</p>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">KTP & NIK</span>
                                <span class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">NIB (13 Digit)</span>
                                <span class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">WA & Email Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative pl-0 md:pl-20 group">
                        <div class="absolute left-0 top-0 w-14 h-14 bg-white text-indigo-600 border-2 border-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl z-10 shadow-lg transition-transform group-hover:scale-110">3</div>
                        <div class="card-3d bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                            <div class="absolute top-[-20px] right-[-20px] text-8xl opacity-10 grayscale group-hover:grayscale-0 transition-all duration-500">🏬</div>
                            <h3 class="text-2xl font-black mb-4">Informasi Usaha</h3>
                            <p class="text-slate-500 mb-6 font-medium">Bantu kami memahami jenis produk dan lokasi operasional bisnis Anda.</p>
                            <div class="p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100/50">
                                <p class="text-xs text-indigo-600 font-bold leading-relaxed">Mencakup: Nama Produk, Alamat Usaha, Jenis Sektor, Tahun Berdiri, dan Skala Usaha.</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative pl-0 md:pl-20 group">
                        <div class="absolute left-0 top-0 w-14 h-14 bg-white text-indigo-600 border-2 border-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl z-10 shadow-lg transition-transform group-hover:scale-110">4</div>
                        <div class="card-3d bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                            <div class="absolute top-[-20px] right-[-20px] text-8xl opacity-10 grayscale group-hover:grayscale-0 transition-all duration-500">📈</div>
                            <h3 class="text-2xl font-black mb-4">Kondisi Bisnis</h3>
                            <p class="text-slate-500 mb-4 font-medium">Potret nyata performa bisnis Anda untuk penyesuaian materi pelatihan.</p>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-3 text-sm font-semibold text-slate-600">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                    Omzet & Karyawan
                                </li>
                                <li class="flex items-center gap-3 text-sm font-semibold text-slate-600">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>
                                    Tantangan Utama & Media Penjualan
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="relative pl-0 md:pl-20 group">
                        <div class="absolute left-0 top-0 w-14 h-14 bg-white text-indigo-600 border-2 border-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl z-10 shadow-lg transition-transform group-hover:scale-110">5</div>
                        <div class="card-3d bg-white p-8 md:p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                            <div class="absolute top-[-20px] right-[-20px] text-8xl opacity-10 grayscale group-hover:grayscale-0 transition-all duration-500">🚀</div>
                            <h3 class="text-2xl font-black mb-4">Tahap Pengembangan</h3>
                            <p class="text-slate-500 mb-6 font-medium">Sejauh mana Anda ingin berkembang dalam 6 bulan ke depan?</p>
                            <div class="text-xs font-bold text-slate-400 italic">"Target usaha saya adalah mencapai Go-Digital!"</div>
                        </div>
                    </div>

                    <div class="relative pl-0 md:pl-20 group">
                        <div class="absolute left-0 top-0 w-14 h-14 bg-green-500 text-white rounded-2xl flex items-center justify-center font-black text-xl z-10 shadow-lg shadow-green-100 transition-transform group-hover:scale-110">6</div>
                        <div class="card-3d bg-slate-900 p-8 md:p-10 rounded-[2.5rem] text-white overflow-hidden relative">
                            <div class="relative z-10">
                                <h3 class="text-2xl font-black mb-4">Kirim Pendaftaran</h3>
                                <p class="text-slate-400 mb-8 font-medium italic">Selesai! Data Anda akan masuk ke sistem kami untuk diverifikasi secara aman.</p>
<a href="{{ route('daftar') }}" 
   class="inline-block w-full md:w-auto px-10 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-black transition-all shadow-xl shadow-indigo-900/20 active:scale-95 text-center">
    MULAI DAFTAR SEKARANG
</a>
                            <div class="absolute bottom-[-30px] right-[-10px] text-9xl opacity-20">✅</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="py-16 bg-white border-t border-slate-100">
        <div class="container mx-auto px-6 text-center">
            <p class="text-slate-400 font-bold text-xs uppercase tracking-[0.3em] mb-4">Privasi Keamanan</p>
            <p class="text-slate-600 max-w-xl mx-auto text-sm leading-relaxed">
                Seluruh data yang Anda kirimkan dijamin kerahasiaannya oleh <br><strong>Dinas Tenaga Kerja, KUKM Kota Madiun</strong>.
            </p>
        </div>
    </footer>

</body>
</html>