<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran IKM Juara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .step-active { @apply bg-indigo-600 text-white; }
        .hidden { display: none; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">

    <nav class="px-12 py-6 bg-white border-b border-slate-100 mb-10">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold text-slate-800 italic">IKM<span class="text-yellow-500">JUARA</span></a>
            <a href="/" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition">← KEMBALI KE BERANDA</a>
        </div>
    </nav>

    <div class="container mx-auto px-6 max-w-3xl">
        <div class="flex justify-between mb-12 relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-200 -z-10 -translate-y-1/2"></div>
            <div id="step-1-badge" class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold shadow-lg shadow-indigo-200">1</div>
            <div id="step-2-badge" class="w-10 h-10 rounded-full bg-white text-slate-400 flex items-center justify-center font-bold border-2 border-slate-200">2</div>
            <div id="step-3-badge" class="w-10 h-10 rounded-full bg-white text-slate-400 flex items-center justify-center font-bold border-2 border-slate-200">3</div>
        </div>

        <div class="bg-white rounded-[40px] shadow-xl shadow-slate-200/60 p-10 border border-slate-100">
            <form id="regForm" action="/simpan-pendaftaran" method="POST">
                @csrf
                
                <div class="tab space-y-6">
                    <h2 class="text-2xl font-black text-slate-800">Profil Pemilik Usaha</h2>
                    <p class="text-slate-400 text-sm">Masukan informasi pribadi Anda sesuai KTP Madiun.</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">NIK (Sesuai KTP)</label>
                            <input type="number" name="nik" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" placeholder="16 Digit Nomor Induk Kependudukan">
                        </div>
                    </div>
                </div>

                <div class="tab hidden space-y-6">
                    <h2 class="text-2xl font-black text-slate-800">Detail IKM / Usaha</h2>
                    <p class="text-slate-400 text-sm">Beritahu kami lebih lanjut tentang produk hebat Anda.</p>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Brand/Usaha</label>
                            <input type="text" name="nama_usaha" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" placeholder="Contoh: Sambel Pecel Madiun Juara">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kecamatan Lokasi Usaha</label>
                            <select name="kecamatan" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                                <option>Kartoharjo</option>
                                <option>Manguharjo</option>
                                <option>Taman</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="tab hidden text-center space-y-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800">Siap Menjadi Juara?</h2>
                    <p class="text-slate-400 px-10 italic">Dengan menekan tombol simpan, data Anda akan diverifikasi oleh tim Disnaker KUKM Kota Madiun dalam waktu 2x24 jam.</p>
                </div>

                <div class="flex justify-between mt-12 pt-8 border-t border-slate-50">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="px-8 py-4 rounded-2xl font-bold text-slate-400 hover:text-slate-600 transition">Kembali</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">Lanjutkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var currentTab = 0;
        showTab(currentTab);

        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.visibility = "hidden";
            } else {
                document.getElementById("prevBtn").style.visibility = "visible";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Simpan Data";
                document.getElementById("nextBtn").classList.replace("bg-indigo-600", "bg-green-600");
            } else {
                document.getElementById("nextBtn").innerHTML = "Lanjutkan";
                document.getElementById("nextBtn").classList.replace("bg-green-600", "bg-indigo-600");
            }
            updateStepper(n);
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                document.getElementById("regForm").submit();
                return false;
            }
            showTab(currentTab);
        }

        function updateStepper(n) {
            for(let i=1; i<=3; i++) {
                let badge = document.getElementById("step-"+i+"badge");
                if(i <= n+1) {
                    badge.classList.add("bg-indigo-600", "text-white");
                    badge.classList.remove("bg-white", "text-slate-400");
                } else {
                    badge.classList.remove("bg-indigo-600", "text-white");
                    badge.classList.add("bg-white", "text-slate-400");
                }
            }
        }
    </script>
</body>
</html>