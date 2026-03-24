<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelatihan UMKM Madiun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <style>
        .step-content { display: none; }
        .step-content.active { display: block; }
        .custom-checkbox:checked + div, .custom-radio:checked + div {
            border-color: #4f46e5;
            background-color: #f5f3ff;
            color: #4338ca;
        }
        #progress-bar { transition: width 0.5s ease-in-out; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .shake { animation: shake 0.2s ease-in-out 0s 2; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900">

    <div class="max-w-3xl mx-auto my-10 px-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-indigo-900">Formulir Registrasi Pelatihan</h1>
            <p class="text-slate-500 mt-2">Data ini membantu kami menyesuaikan materi dengan kondisi usaha Anda.</p>
        </div>

        {{-- BAGIAN NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-5 mb-6 rounded-xl shadow-lg flex items-center animate-bounce">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <div>
                    <p class="font-bold">Pendaftaran Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
            <script>
                // Scroll otomatis ke notifikasi jika muncul
                window.scrollTo({ top: 0, behavior: 'smooth' });
                // Hilangkan notifikasi setelah 10 detik
                setTimeout(() => {
                    document.getElementById('success-alert')?.remove();
                }, 10000);
            </script>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
                <p class="font-bold mb-2">Mohon perbaiki kesalahan berikut:</p>
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
            <div class="h-2 bg-slate-100">
                <div id="progress-bar" class="h-full bg-indigo-600" style="width: 20%"></div>
            </div>

            <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm" onsubmit="return finalCheck()">
                @csrf

                <div class="step-content active p-8" id="step-1">
                    <div class="bg-indigo-50 p-6 rounded-2xl mb-6 border border-indigo-100">
                        <h3 class="font-bold text-indigo-800 mb-2">Penting untuk Diketahui:</h3>
                        <p class="text-sm text-indigo-700 leading-relaxed italic">"Data ini digunakan untuk menyesuaikan materi pelatihan agar sesuai dengan kondisi usaha Anda. Semua informasi bersifat rahasia."</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kegiatan Pelatihan:</label>
                        <select name="nama_kegiatan" id="pilih_kegiatan" onchange="updateDetail()" class="w-full border border-slate-200 rounded-xl px-4 py-4 outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            @if(isset($list_kegiatan) && $list_kegiatan->count() > 0)
                                @foreach($list_kegiatan as $keg)
                                    <option value="{{ $keg->nama_kegiatan }}" 
                                            data-tempat="{{ $keg->tempat_kegiatan }}" 
                                            data-jadwal="{{ \Carbon\Carbon::parse($keg->tgl_mulai)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($keg->tgl_selesai)->format('d M Y') }}"
                                            data-deskripsi="{{ $keg->deskripsi_kegiatan }}">
                                        {{ $keg->nama_kegiatan }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div id="info_kegiatan" class="hidden bg-blue-50 border-l-4 border-blue-500 p-5 mb-6 rounded-r-2xl">
                        <p class="text-xs font-bold text-blue-800 uppercase tracking-wider">Detail Kegiatan:</p>
                        <p class="text-sm text-gray-700 mt-2" id="text_jadwal"></p>
                        <p class="text-sm text-gray-700 font-semibold" id="text_tempat"></p>
                        <p class="text-xs text-gray-500 mt-2 italic border-t border-blue-100 pt-2" id="text_deskripsi"></p>
                    </div>

                    <button type="button" onclick="goToStep(2)" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl transition shadow-lg transform active:scale-[0.98]">
                        Mulai Mendaftar (2-3 Menit) <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>

                <div class="step-content p-8" id="step-2">
                    <h2 class="text-xl font-bold mb-6 text-indigo-900"><i class="fas fa-user-circle mr-2 text-indigo-500"></i>Data Diri Peserta</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" placeholder="Sesuai KTP" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" value="{{ old('nama_lengkap') }}" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1">NIK (Wajib 16 Digit)</label>
                            <input type="text" name="nik" id="nik" maxlength="16" placeholder="Contoh: 3515xxxxxxxxxxxx" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1">NIB (Wajib 13 Digit)</label>
                            <input type="text" name="nib" id="nib" maxlength="13" placeholder="Contoh: 0123xxxxxxxx" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1">Email Aktif</label>
                            <input type="email" name="email" placeholder="contoh@gmail.com" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" value="{{ old('email') }}" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" placeholder="Contoh: 0812xxxxxxx" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" value="{{ old('whatsapp') }}" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-slate-500 ml-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <label class="block mb-2 font-medium text-slate-700">Unggah Foto KTP:</label>
                        <div class="relative border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 transition cursor-pointer group">
                            <input type="file" name="foto_ktp" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewFile(this)" accept="image/*" required>
                            <div id="upload-label">
                                <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 mb-2 group-hover:text-indigo-400 transition"></i>
                                <p class="text-sm text-slate-500">Klik untuk upload foto KTP Anda</p>
                            </div>
                            <img id="preview-img" class="hidden mx-auto h-40 rounded-lg shadow-md border-2 border-white">
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" onclick="goToStep(1)" class="w-1/3 py-4 border rounded-2xl font-bold text-slate-500 hover:bg-slate-100 transition">Kembali</button>
                        <button type="button" onclick="goToStep(3)" class="w-2/3 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:shadow-lg transition transform active:scale-95">Lanjut ke Info Usaha</button>
                    </div>
                </div>

                <div class="step-content p-8" id="step-3">
                    <h2 class="text-xl font-bold mb-6 text-indigo-900"><i class="fas fa-store mr-2 text-indigo-500"></i>Informasi Usaha</h2>
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1 text-sm">Nama Usaha / Produk</label>
                            <input type="text" name="nama_usaha" placeholder="Contoh: Keripik Tempe Barokah" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>
                        
                        <input type="hidden" name="kota" value="Madiun">
                        
                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1 text-sm">Alamat Lengkap Usaha</label>
                            <textarea name="alamat_usaha" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Jl. Pahlawan No. 12, Kota Madiun" required>{{ old('alamat_usaha') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-slate-500 ml-1 text-sm">Kecamatan</label>
                                <input type="text" name="kecamatan" placeholder="Kecamatan" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-slate-500 ml-1 text-sm">Kelurahan</label>
                                <input type="text" name="kelurahan" placeholder="Kelurahan" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-slate-500 ml-1 text-sm">Jenis Usaha</label>
                            <select name="jenis_usaha" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                                <option value="">Pilih Jenis Usaha...</option>
                                <option value="Kuliner">Kuliner</option>
                                <option value="Fashion">Fashion</option>
                                <option value="Jasa">Jasa</option>
                                <option value="Kriya">Kriya</option>
                                <option value="Kerajinan">Kerajinan</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-slate-500 ml-1 text-sm">Tahun Mulai</label>
                                <input type="number" name="tahun_mulai" placeholder="Contoh: 2020" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-slate-500 ml-1 text-sm">Skala Usaha</label>
                                <select name="skala_usaha" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="Mikro">Mikro</option>
                                    <option value="Kecil">Kecil</option>
                                    <option value="Menengah">Menengah</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" onclick="goToStep(2)" class="w-1/3 py-4 border rounded-2xl hover:bg-slate-100 transition font-bold">Kembali</button>
                        <button type="button" onclick="goToStep(4)" class="w-2/3 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:shadow-lg transition transform active:scale-95">Lanjut ke Kondisi Bisnis</button>
                    </div>
                </div>

                <div class="step-content p-8" id="step-4">
                    <h2 class="text-xl font-bold mb-6 text-indigo-900"><i class="fas fa-chart-line mr-2 text-indigo-500"></i>Kondisi Bisnis</h2>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-sm font-medium">Omzet per bulan (Rupiah)?</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 font-bold text-sm">Rp</span>
                                    </div>
                                    <input type="text" name="omzet_bulanan" id="omzet_input" placeholder="Contoh: 5.000.000" class="w-full p-4 pl-12 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition" oninput="handleRupiah(this)" required>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium">Stabilitas Omzet</label>
                                <select name="stabilitas_omzet" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="Ya">Ya, Stabil</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="Musiman">Musiman</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="block font-medium text-sm">Tantangan Utama (Bisa pilih > 1):</label>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                @php $tantangan = ['Penjualan sepi', 'Marketing kurang efektif', 'Modal terbatas', 'Produksi terbatas', 'SDM kurang', 'Lainnya']; @endphp
                                @foreach($tantangan as $t)
                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="tantangan[]" value="{{ $t }}" class="hidden custom-checkbox">
                                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl transition-all group-hover:bg-indigo-50 flex items-center gap-2">
                                        <i class="fas fa-tag opacity-20 text-[10px]"></i> {{ $t }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block font-medium text-sm">Media Penjualan:</label>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                @php $medias = ['Offline (toko)', 'WhatsApp', 'Instagram', 'Marketplace', 'Website']; @endphp
                                @foreach($medias as $m)
                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="media[]" value="{{ $m }}" class="hidden custom-checkbox">
                                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl transition-all group-hover:bg-indigo-50 flex items-center gap-2">
                                        <i class="fas fa-share-alt opacity-20 text-[10px]"></i> {{ $m }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs text-slate-500">Jumlah Karyawan Tetap</label>
                                <input type="number" name="karyawan_tetap" value="0" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs text-slate-500">Karyawan Tidak Tetap</label>
                                <input type="number" name="karyawan_tidak_tetap" value="0" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" onclick="goToStep(3)" class="w-1/3 py-4 border rounded-2xl hover:bg-slate-100 transition font-bold">Kembali</button>
                        <button type="button" onclick="goToStep(5)" class="w-2/3 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:shadow-lg transition">Langkah Terakhir</button>
                    </div>
                </div>

                <div class="step-content p-8" id="step-5">
                    <h2 class="text-xl font-bold mb-4 text-indigo-900"><i class="fas fa-rocket mr-2 text-indigo-500"></i>Langkah Terakhir</h2>
                    <div class="space-y-6">
                        
                        <div class="space-y-3">
                            <label class="font-medium text-sm">Tingkat Digital Marketing:</label>
                            <div class="grid grid-cols-1 gap-2">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="level_digital" value="Belum" required class="hidden custom-radio">
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3 group-hover:bg-indigo-50 transition">
                                        <div class="w-4 h-4 border-2 border-slate-300 rounded-full flex items-center justify-center group-checked:border-indigo-600">
                                            <div class="w-2 h-2 bg-indigo-600 rounded-full opacity-0 group-checked:opacity-100"></div>
                                        </div>
                                        Belum menggunakan
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="level_digital" value="Sudah tapi belum maksimal" class="hidden custom-radio">
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3 group-hover:bg-indigo-50 transition">
                                        <div class="w-4 h-4 border-2 border-slate-300 rounded-full flex items-center justify-center group-checked:border-indigo-600">
                                            <div class="w-2 h-2 bg-indigo-600 rounded-full opacity-0 group-checked:opacity-100"></div>
                                        </div>
                                        Sudah tapi belum maksimal
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="level_digital" value="Sudah aktif" class="hidden custom-radio">
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center gap-3 group-hover:bg-indigo-50 transition">
                                        <div class="w-4 h-4 border-2 border-slate-300 rounded-full flex items-center justify-center group-checked:border-indigo-600">
                                            <div class="w-2 h-2 bg-indigo-600 rounded-full opacity-0 group-checked:opacity-100"></div>
                                        </div>
                                        Sudah aktif & rutin
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="font-medium text-sm">Apakah Anda pernah mengikuti pelatihan UMKM sebelumnya?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="pernah_pelatihan" value="Pernah" class="w-4 h-4 accent-indigo-600" required> 
                                    <span class="text-sm">Pernah</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="pernah_pelatihan" value="Belum" checked class="w-4 h-4 accent-indigo-600"> 
                                    <span class="text-sm">Belum</span>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium">Apa harapan Anda setelah mengikuti pelatihan ini?</label>
                            <textarea name="harapan_pelatihan" rows="2" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Ingin bisa jualan di TikTok atau memperluas jaringan reseller..." required></textarea>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium">Apa target usaha Anda dalam 6 bulan ke depan?</label>
                            <textarea name="target_6_bulan" rows="2" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Contoh: Menambah 3 reseller baru atau omzet naik 2x lipat..." required></textarea>
                        </div>

                        <input type="hidden" name="sistem_usaha" value="Sendiri">

                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 text-[11px] text-amber-800 space-y-2">
                            <p><i class="fas fa-lock mr-2"></i> Data dijaga kerahasiaannya untuk kebutuhan program.</p>
                            <p><i class="fas fa-phone mr-2"></i> Bersedia dihubungi panitia untuk informasi pelaksanaan.</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="button" onclick="goToStep(4)" class="w-1/3 py-4 border rounded-2xl hover:bg-slate-100 transition font-bold">Kembali</button>
                        <button type="submit" id="submitBtn" class="w-2/3 py-4 bg-indigo-700 hover:bg-indigo-800 text-white rounded-2xl font-extrabold shadow-lg transition transform active:scale-95">Kirim Pendaftaran 🚀</button>
                    </div>
                </div>
            </form>
        </div>
        <p class="text-center text-slate-400 text-xs mt-8 font-medium">IKM Maju Madiun Mendunia &copy; 2026</p>
    </div>

<script>
    function updateDetail() {
        const select = document.getElementById('pilih_kegiatan');
        const option = select.options[select.selectedIndex];
        const infoBox = document.getElementById('info_kegiatan');

        if (select.value !== "") {
            infoBox.classList.remove('hidden');
            document.getElementById('text_jadwal').innerText = "📅 Jadwal: " + option.getAttribute('data-jadwal');
            document.getElementById('text_tempat').innerText = "📍 Tempat: " + option.getAttribute('data-tempat');
            document.getElementById('text_deskripsi').innerText = option.getAttribute('data-deskripsi');
        } else {
            infoBox.classList.add('hidden');
        }
    }

    function goToStep(step) {
        const currentActive = document.querySelector('.step-content.active');
        const currentStepId = currentActive ? parseInt(currentActive.id.replace('step-', '')) : 1;

        if (step > currentStepId) {
            const inputs = currentActive.querySelectorAll('input[required], select[required], textarea[required]');
            let allValid = true;

            // Bersihkan error lama
            currentActive.querySelectorAll('.error-msg').forEach(el => el.remove());
            currentActive.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500', 'shake'));

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    const name = input.name;
                    const checked = currentActive.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        allValid = false;
                        showError(input.closest('.grid') || input.parentNode, "Pilih salah satu");
                    }
                } 
                else if (!input.value.trim() || (input.type === 'file' && input.files.length === 0)) {
                    allValid = false;
                    input.classList.add('border-red-500', 'shake');
                    showError(input, "Bidang ini wajib diisi");
                } 
                else if (input.name === 'nik' && input.value.length < 16) {
                    allValid = false;
                    input.classList.add('border-red-500', 'shake');
                    showError(input, "NIK harus 16 digit");
                } else if (input.name === 'nib' && input.value.length < 13) {
                    allValid = false;
                    input.classList.add('border-red-500', 'shake');
                    showError(input, "NIB harus 13 digit");
                }
            });
            if (!allValid) return;
        }

        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        const targetStep = document.getElementById('step-' + step);
        if(targetStep) {
            targetStep.classList.add('active');
            let progress = (step / 5) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    function showError(element, message) {
        const error = document.createElement('p');
        error.className = 'error-msg text-[10px] text-red-500 mt-1 ml-1';
        error.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i> ${message}`;
        element.parentNode.appendChild(error);
    }

    function previewFile(input) {
        const preview = document.getElementById('preview-img');
        const label = document.getElementById('upload-label');
        const file = input.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (event) {
            const img = new Image();
            img.src = event.target.result;
            img.onload = function () {
                const canvas = document.createElement('canvas');
                const MAX_WIDTH = 1200; 
                let width = img.width;
                let height = img.height;
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);
                canvas.toBlob((blob) => {
                    const compressedFile = new File([blob], file.name, { type: 'image/jpeg' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    input.files = dataTransfer.files;
                    preview.src = URL.createObjectURL(compressedFile);
                    preview.classList.remove('hidden');
                    label.classList.add('hidden');
                }, 'image/jpeg', 0.7); 
            };
        };
    }

function handleRupiah(element) {
        let value = element.value.replace(/[^0-9]/g, ""); 
        if (value !== "") {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = "";
        }
    }

    // FUNGSI PENTING: Membersihkan format rupiah sebelum dikirim ke database
function finalCheck() {
        const omzetInput = document.getElementById('omzet_input');
        const btn = document.getElementById('submitBtn');

        // Hapus semua titik agar menjadi angka murni (Integer) sebelum masuk ke database
        if (omzetInput && omzetInput.value) {
            omzetInput.value = omzetInput.value.replace(/\./g, '');
        }
        
        // Efek loading pada tombol
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...';
            btn.disabled = true;
        }
        return true;
    }
</script>
</body>
</html>