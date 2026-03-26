<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil IKM JUARA - Kota Madiun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <nav class="p-6 flex justify-between items-center bg-white shadow-sm">
        <a href="/" class="flex items-center gap-2">
            <img src="/logo-ikm.png" class="h-10"> <span class="font-bold text-xl uppercase">IKM<span class="text-yellow-500">JUARA</span></span>
        </a>
        <a href="/" class="text-slate-500 font-bold">KEMBALI KE BERANDA</a>
    </nav>

    <div class="bg-slate-50" x-data="{ section: 'latar' }">
<div class="bg-slate-50" x-data="{ section: 'latar' }">
    
    <section class="relative py-24 bg-indigo-700 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-indigo-500/30 backdrop-blur-md border border-indigo-400 text-white rounded-full text-xs font-bold uppercase tracking-[0.2em] mb-6">
                Inovasi Pelayanan Publik
            </span>
            <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
                IKM <span class="text-yellow-400">JUARA</span>
            </h1>
            <p class="text-indigo-100 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed font-medium">
                Integrasi Konsultasi Mandiri untuk Jaminan Usaha, Akselerasi, dan Produktivitas Industri Anda.
            </p>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <button @click="section = 'latar'" :class="section === 'latar' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-500 hover:bg-slate-100'" class="px-8 py-3 rounded-2xl font-bold transition-all duration-300">Latar Belakang</button>
                <button @click="section = 'deskripsi'" :class="section === 'deskripsi' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-500 hover:bg-slate-100'" class="px-8 py-3 rounded-2xl font-bold transition-all duration-300">Deskripsi & Tujuan</button>
                <button @click="section = 'keunggulan'" :class="section === 'keunggulan' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-500 hover:bg-slate-100'" class="px-8 py-3 rounded-2xl font-bold transition-all duration-300">Keunggulan & Manfaat</button>
                <button @click="section = 'dampak'" :class="section === 'dampak' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-500 hover:bg-slate-100'" class="px-8 py-3 rounded-2xl font-bold transition-all duration-300">Dampak & Sasaran</button>
            </div>

            <div class="max-w-5xl mx-auto">
                
                <div x-show="section === 'latar'" x-transition:enter="transition ease-out duration-500" class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900 mb-6 border-l-8 border-indigo-600 pl-6">Latar Belakang</h2>
                        <div class="space-y-4 text-slate-600 leading-relaxed text-lg">
                            <p>Industri Kecil dan Menengah (IKM) memiliki peran strategis dalam mendorong pertumbuhan ekonomi daerah di Kota Madiun.</p>
                            <p>Namun, tantangan seperti <strong>keterbatasan informasi, lemahnya branding, dan minimnya legalitas</strong> menjadi penghambat utama. IKM JUARA lahir sebagai respon cerdas Disnaker KUKM untuk mengintegrasikan berbagai layanan pembinaan dalam satu pintu.</p>
                        </div>
                    </div>
                    <div class="bg-indigo-50 p-8 rounded-[3rem] border border-indigo-100">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-indigo-600 font-bold">01</div>
                            <h4 class="font-bold text-slate-800 text-xl">Respon Kebutuhan</h4>
                        </div>
                        <p class="text-slate-500 italic">"Mewujudkan ekosistem industri lokal yang inovatif, mandiri, dan berdaya saing tinggi."</p>
                    </div>
                </div>

                <div x-show="section === 'deskripsi'" x-transition:enter="transition ease-out duration-500" class="space-y-12">
                    <div class="text-center max-w-2xl mx-auto mb-10">
                        <h2 class="text-3xl font-black text-slate-900 mb-4">Misi Strategis IKM JUARA</h2>
                        <p class="text-slate-500 text-lg">Pendampingan komprehensif dari tahap perintisan hingga pengembangan skala industri.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-300 transition group">
                            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-xl mb-3">Legalisasi Cepat</h4>
                            <p class="text-slate-500 text-sm">Akselerasi proses NIB, Sertifikasi Halal, dan HKI dalam satu sistem.</p>
                        </div>
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-300 transition group">
                            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-xl mb-3">Digital Marketing</h4>
                            <p class="text-slate-500 text-sm">Transformasi pemasaran produk IKM melalui pendampingan digital kreatif.</p>
                        </div>
                        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm hover:border-indigo-300 transition group">
                            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-xl mb-3">Konsultasi Bisnis</h4>
                            <p class="text-slate-500 text-sm">Layanan klinik konsultasi industri yang mudah diakses dan terpadu.</p>
                        </div>
                    </div>
                </div>

                <div x-show="section === 'keunggulan'" x-transition:enter="transition ease-out duration-500">
                    <div class="bg-white rounded-[3rem] overflow-hidden shadow-xl border border-slate-100 flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-12 bg-slate-900 text-white">
                            <h3 class="text-2xl font-bold mb-8">Lima Pilar Keunggulan</h3>
                            <ul class="space-y-6">
                                <li class="flex items-start gap-4">
                                    <span class="text-indigo-400 font-black">01.</span>
                                    <div><p class="font-bold">Terintegrasi</p><p class="text-slate-400 text-sm">Layanan satu pintu (one-stop service).</p></div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="text-indigo-400 font-black">02.</span>
                                    <div><p class="font-bold">Customized Service</p><p class="text-slate-400 text-sm">Sesuai kebutuhan spesifik IKM.</p></div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <span class="text-indigo-400 font-black">03.</span>
                                    <div><p class="font-bold">Berkelanjutan</p><p class="text-slate-400 text-sm">Pendampingan pasca pelatihan.</p></div>
                                </li>
                            </ul>
                        </div>
                        <div class="md:w-1/2 p-12">
                            <h3 class="text-2xl font-bold text-slate-900 mb-8">Manfaat Nyata</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-indigo-50 text-indigo-700 font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Kualitas Produk Meningkat
                                </div>
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-green-50 text-green-700 font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Legalitas Usaha Terjamin
                                </div>
                                <div class="flex items-center gap-4 p-4 rounded-2xl bg-yellow-50 text-yellow-700 font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Akses Pasar Lebih Luas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="section === 'dampak'" x-transition:enter="transition ease-out duration-500">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-10 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm">
                            <h3 class="text-2xl font-black text-slate-900 mb-6">Sasaran Inovasi</h3>
                            <div class="flex flex-wrap gap-3">
                                <span class="px-5 py-2 bg-slate-100 rounded-full text-slate-700 font-bold">Pelaku IKM</span>
                                <span class="px-5 py-2 bg-slate-100 rounded-full text-slate-700 font-bold">Wirausaha Baru</span>
                                <span class="px-5 py-2 bg-slate-100 rounded-full text-slate-700 font-bold">IKM Scale Up</span>
                            </div>
                        </div>
                        <div class="p-10 bg-indigo-600 rounded-[2.5rem] text-white">
                            <h3 class="text-2xl font-black mb-6">Dampak Positif</h3>
                            <p class="text-indigo-100 leading-relaxed mb-6">Meningkatnya kesadaran legalitas usaha, kualitas pelayanan publik yang lebih terstruktur, dan terciptanya ekosistem kompetitif.</p>
                            <div class="h-2 w-full bg-indigo-400 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 w-[85%]"></div>
                            </div>
                            <p class="text-xs mt-3 opacity-80">Peningkatan Indeks Kepuasan Masyarakat</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-900 text-white rounded-t-[4rem]">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8 italic">"Siap Bersaing di Tingkat Nasional maupun Global"</h2>
            <p class="max-w-2xl mx-auto text-slate-400 leading-relaxed mb-12">
                IKM JUARA hadir sebagai solusi nyata. Inovasi ini memiliki potensi replikasi tinggi bagi daerah lain guna mendukung program nasional pengembangan UMKM.
            </p>
            <div class="flex flex-wrap justify-center gap-10 opacity-60">
                <p class="font-bold tracking-widest uppercase text-xs">Integrasi</p>
                <p class="font-bold tracking-widest uppercase text-xs">Konsultasi</p>
                <p class="font-bold tracking-widest uppercase text-xs">Akselerasi</p>
                <p class="font-bold tracking-widest uppercase text-xs">Produktivitas</p>
            </div>
        </div>
    </section>
</div>
</div>

</body>
</html>