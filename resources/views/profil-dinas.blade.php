<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Dinas - Tenaga Kerja, Koperasi & UKM Kota Madiun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold">M</div>
                <span class="font-extrabold text-xl tracking-tight">DINAS <span class="text-indigo-600">NAKER KUKM</span></span>
            </a>
            <a href="/" class="group flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-all">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                KEMBALI KE BERANDA
            </a>
        </div>
    </nav>

    <header class="relative py-20 bg-slate-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500 rounded-full filter blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full filter blur-[100px] translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">
                Dinas Tenaga Kerja, Koperasi, <br>dan Usaha Kecil Menengah
            </h1>
            <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto font-medium">
                Pemerintah Kota Madiun
            </p>
        </div>
    </header>

    <main class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <aside class="lg:col-span-4 space-y-4">
                <div class="sticky top-28 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 px-2">Menu Profil</h3>
                    <nav class="flex flex-col gap-2">
                        <a href="#umum" class="px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 font-bold transition-all text-slate-600">Gambaran Umum</a>
                        <a href="#visimisi" class="px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 font-bold transition-all text-slate-600">Visi & Misi</a>
                        <a href="#struktur" class="px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 font-bold transition-all text-slate-600">Struktur Organisasi</a>
                        <a href="#program" class="px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 font-bold transition-all text-slate-600">Program Unggulan</a>
                        <a href="#kontak" class="px-4 py-3 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 font-bold transition-all text-slate-600">Kontak Kami</a>
                    </nav>
                </div>
            </aside>

            <div class="lg:col-span-8 space-y-20">
                
                <section id="umum" class="scroll-mt-28">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="w-12 h-1 bg-indigo-600 rounded-full"></span>
                        <h2 class="text-3xl font-extrabold">Gambaran Umum</h2>
                    </div>
                    <div class="prose prose-lg text-slate-600 leading-relaxed space-y-6">
                        <p>Dinas Tenaga Kerja, Koperasi, dan Usaha Kecil Menengah Kota Madiun merupakan perangkat daerah yang memiliki peran strategis dalam mendukung pembangunan ekonomi daerah melalui penguatan tenaga kerja, koperasi, serta sektor usaha kecil dan menengah (IKM/UMKM).</p>
                        <p>Dinas ini berkedudukan sebagai unsur pelaksana urusan pemerintahan daerah yang dipimpin oleh Kepala Dinas dan bertanggung jawab kepada Wali Kota melalui Sekretaris Daerah.</p>
                    </div>
                </section>

                <section id="visimisi" class="scroll-mt-28 bg-indigo-600 p-10 md:p-16 rounded-[3rem] text-white">
                    <div class="mb-12">
                        <h3 class="text-sm font-black uppercase tracking-[0.3em] mb-4 opacity-70">Visi Kami</h3>
                        <p class="text-2xl md:text-4xl font-extrabold italic leading-tight">
                            “Terwujudnya Pemerintahan Bersih Berwibawa Menuju Masyarakat Sejahtera.”
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-[0.3em] mb-8 opacity-70">Misi Kami</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <li class="flex gap-4 items-start bg-white/10 p-5 rounded-2xl">
                                <span class="font-bold text-yellow-400">01</span>
                                <p class="text-sm font-medium">Meningkatkan kualitas hidup masyarakat Kota Madiun.</p>
                            </li>
                            <li class="flex gap-4 items-start bg-white/10 p-5 rounded-2xl">
                                <span class="font-bold text-yellow-400">02</span>
                                <p class="text-sm font-medium">Mewujudkan tata kelola pemerintahan yang baik (Good Governance).</p>
                            </li>
                            <li class="flex gap-4 items-start bg-white/10 p-5 rounded-2xl">
                                <span class="font-bold text-yellow-400">03</span>
                                <p class="text-sm font-medium">Mewujudkan kemandirian ekonomi dan pemerataan kesejahteraan.</p>
                            </li>
                            <li class="flex gap-4 items-start bg-white/10 p-5 rounded-2xl">
                                <span class="font-bold text-yellow-400">04</span>
                                <p class="text-sm font-medium">Meningkatkan keterbukaan informasi publik.</p>
                            </li>
                        </ul>
                    </div>
                </section>

                <section id="struktur" class="scroll-mt-28">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="w-12 h-1 bg-indigo-600 rounded-full"></span>
                        <h2 class="text-3xl font-extrabold">Struktur Organisasi</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm font-bold">Kepala Dinas</div>
                        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm font-bold">Sekretariat</div>
                        <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm font-bold text-indigo-700">Bidang Tenaga Kerja</div>
                        <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm font-bold text-indigo-700">Bidang Koperasi & UKM</div>
                        <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm font-bold text-indigo-700">Bidang Perindustrian</div>
                        <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm font-bold">UPTD & Jabatan Fungsional</div>
                    </div>
                </section>

                <section id="program" class="scroll-mt-28">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="w-12 h-1 bg-indigo-600 rounded-full"></span>
                        <h2 class="text-3xl font-extrabold">Program & Layanan Unggulan</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group p-8 bg-white border border-slate-100 rounded-[2.5rem] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <h4 class="font-black text-slate-800 mb-4">Pelatihan Kerja</h4>
                            <p class="text-slate-500 text-sm">Pelatihan berbasis kompetensi, pemagangan, dan penempatan tenaga kerja.</p>
                        </div>
                        <div class="group p-8 bg-white border border-slate-100 rounded-[2.5rem] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <h4 class="font-black text-slate-800 mb-4">Pendampingan IKM/UMKM</h4>
                            <p class="text-slate-500 text-sm">Fasilitasi legalitas (NIB, Halal, HKI) dan pelatihan Branding/Digital Marketing.</p>
                        </div>
                    </div>
                </section>

                <section id="kontak" class="scroll-mt-28 p-10 bg-slate-100 rounded-[3rem] border border-slate-200">
                    <h2 class="text-2xl font-extrabold mb-8 text-center">Hubungi Kami</h2>
                    <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                        <div class="text-center">
                            <p class="text-xs font-black uppercase text-slate-400 mb-2">Alamat</p>
                            <p class="font-bold">Jl. Bolodewo No. 8, Kota Madiun</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-black uppercase text-slate-400 mb-2">Telepon</p>
                            <p class="font-bold">(0351) 454288</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-black uppercase text-slate-400 mb-2">Email</p>
                            <p class="font-bold text-indigo-600">naker.madiunkota@gmail.com</p>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </main>

    <footer class="py-10 text-center border-t border-slate-200 text-slate-400 text-xs font-medium">
        &copy; 2026 Pemerintah Kota Madiun - Dinas Tenaga Kerja, Koperasi, dan UKM.
    </footer>

</body>
</html>