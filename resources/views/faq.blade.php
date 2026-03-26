<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - IKM JUARA Kota Madiun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } [x-cloak] { display: none !important; } </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="p-6 bg-white border-b border-slate-100">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="font-black text-2xl uppercase">IKM<span class="text-indigo-600">JUARA</span></a>
            <a href="/" class="text-sm font-bold text-slate-500 hover:text-indigo-600">KEMBALI</a>
        </div>
    </nav>

    <main class="container mx-auto px-6 py-20 max-w-3xl">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold mb-4">Pusat Bantuan</h1>
            <p class="text-slate-500">Temukan jawaban cepat untuk kendala pendaftaran dan pelatihan Anda.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                <button @click="active !== 1 ? active = 1 : active = null" class="w-full p-6 text-left flex justify-between items-center hover:bg-slate-50 transition-all">
                    <span class="font-bold">Bagaimana jika NIB saya belum keluar?</span>
                    <svg class="w-5 h-5 transition-transform" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div x-show="active === 1" x-collapse x-cloak class="px-6 pb-6 text-slate-600 leading-relaxed text-sm">
                    Anda tetap bisa mendaftar dengan melampirkan keterangan "Dalam Proses". Namun, kami sangat menyarankan Anda segera mengurus NIB di OSS agar verifikasi administrasi berjalan lebih cepat.
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                <button @click="active !== 2 ? active = 2 : active = null" class="w-full p-6 text-left flex justify-between items-center hover:bg-slate-50 transition-all">
                    <span class="font-bold">Apakah pelatihan ini dipungut biaya?</span>
                    <svg class="w-5 h-5 transition-transform" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div x-show="active === 2" x-collapse x-cloak class="px-6 pb-6 text-slate-600 leading-relaxed text-sm">
                    Seluruh pelatihan yang diselenggarakan oleh Dinas Tenaga Kerja, KUKM Kota Madiun adalah **Gratis** (Tidak dipungut biaya) bagi warga Kota Madiun yang memenuhi syarat.
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
                <button @click="active !== 3 ? active = 3 : active = null" class="w-full p-6 text-left flex justify-between items-center hover:bg-slate-50 transition-all">
                    <span class="font-bold">Berapa lama proses verifikasi pendaftaran?</span>
                    <svg class="w-5 h-5 transition-transform" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div x-show="active === 3" x-collapse x-cloak class="px-6 pb-6 text-slate-600 leading-relaxed text-sm">
                    Proses verifikasi biasanya memakan waktu 3-7 hari kerja setelah penutupan pendaftaran. Peserta yang lolos akan dihubungi melalui nomor WhatsApp yang terdaftar.
                </div>
            </div>
        </div>
    </main>
</body>
</html>