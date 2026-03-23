<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lengkap Pendaftar IKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-full mx-auto">
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Database Pendaftar IKM Madiun</h2>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
        <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md">
            Total: {{ count($pendaftar) }} Peserta
        </span>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @foreach($statistik as $stat)
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between">
        <div class="flex justify-between items-start mb-2">
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $stat->nama }}</h4>
                <p class="text-2xl font-black text-blue-600">{{ $stat->terisi }} <span class="text-sm text-gray-400 font-normal">/ {{ $stat->kuota }}</span></p>
            </div>
            <div class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-[10px] font-bold">
                {{ $stat->persentase }}%
            </div>
        </div>
        
        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
            <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $stat->persentase }}%"></div>
        </div>
        
        <p class="text-[10px] {{ $stat->sisa <= 5 ? 'text-red-500 font-bold' : 'text-gray-500' }}">
            {{ $stat->sisa <= 0 ? '⚠️ KUOTA HABIS' : 'Sisa Kuota: ' . $stat->sisa . ' Kursi' }}
        </p>
    </div>
    @endforeach
</div>
        <div class="bg-white p-6 rounded-xl shadow-md mb-6 border border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <form action="{{ route('admin.pendaftar') }}" method="GET" class="flex flex-wrap items-end gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] font-bold text-gray-500 uppercase">Filter Kegiatan:</label>
                        <select name="kegiatan" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 min-w-[200px]">
                            <option value="">-- Semua Kegiatan --</option>
                            @foreach($list_kegiatan as $keg)
                                <option value="{{ $keg }}" {{ request('kegiatan') == $keg ? 'selected' : '' }}>{{ $keg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-bold transition">Filter</button>
                        <a href="{{ route('admin.pendaftar') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg text-sm font-bold transition">Reset</a>
                    </div>
                </form>

                <div class="flex gap-2">
                    <a href="{{ route('admin.kegiatan.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Pengaturan Kegiatan
                    </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.recycle') }}" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span>Sampah</span>
                    </a>
                    <a href="{{ route('admin.pendaftar.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center gap-2 transition">
                        <span>📥 Export Excel</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-blue-600 text-white text-[11px] uppercase tracking-wider">
                            <th class="px-3 py-4 border-r border-blue-500">No</th>
                            <th class="px-3 py-4 border-r border-blue-500">Pratinjau KTP</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Biodata Peserta</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Legalitas (NIK/NIB)</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Kontak & Sosmed</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Detail Usaha</th>
                            <th class="px-6 py-4 border-r border-blue-500 text-left">Alamat Lengkap Usaha</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Finansial & SDM</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Digitalisasi & Harapan</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left">Kegiatan Pelatihan</th>
                            <th class="px-3 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-[12px] divide-y divide-gray-200">
                        @foreach($pendaftar as $index => $item)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-3 py-4 text-center font-bold bg-gray-50 border-r">{{ $index + 1 }}</td>
                            
                            <td class="px-3 py-4 border-r text-center">
                                @if($item->foto_ktp)
                                    <div class="relative group">
                                        <img src="{{ $item->foto_ktp }}" 
                                             class="h-14 w-24 object-cover rounded shadow border bg-gray-200 mx-auto"
                                             onerror="this.onerror=null;this.src='https://placehold.co/100x60/e2e8f0/475569?text=Refused';">
                                        <div class="mt-2">
                                            <a href="{{ $item->foto_ktp }}" target="_blank" class="text-[10px] bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200 font-bold">
                                                Buka Link ↗
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-red-400 italic">Data Kosong</span>
                                @endif
                            </td>

                            <td class="px-3 py-4 border-r">
                                <div class="font-bold text-gray-900 leading-tight uppercase">{{ $item->nama_lengkap }}</div>
                                <div class="text-gray-500 mt-1">{{ $item->jenis_kelamin }}</div>
                                <div class="text-[11px] bg-gray-100 inline-block px-1 mt-1">{{ $item->tanggal_lahir }}</div>
                            </td>

                            <td class="px-3 py-4 border-r font-mono tracking-tighter">
                                <div class="mb-1"><span class="text-gray-400">NIK:</span> {{ $item->nik }}</div>
                                <div><span class="text-gray-400">NIB:</span> {{ $item->nib }}</div>
                            </td>

                            <td class="px-3 py-4 border-r">
                                <a href="https://wa.me/{{ $item->whatsapp }}" target="_blank" class="flex items-center gap-1 text-green-600 font-bold hover:underline mb-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48 2.245 2.244 3.481 5.229 3.481 8.406 0 6.556-5.332 11.888-11.89 11.888-2.003 0-3.968-.505-5.711-1.464l-6.271 1.687zm6.54-3.32c1.472.873 3.032 1.333 4.634 1.333 4.965 0 9.006-4.041 9.006-9.006 0-2.405-.936-4.667-2.635-6.367-1.7-1.699-3.962-2.636-6.37-2.636-4.966 0-9.007 4.042-9.007 9.007 0 1.652.451 3.268 1.303 4.685l-1.01 3.693 3.779-.916z"/></svg>
                                    {{ $item->whatsapp }}
                                </a>
                                <div class="text-gray-500 break-all">{{ $item->email }}</div>
                            </td>

                            <td class="px-3 py-4 border-r">
                                <div class="font-bold text-blue-800 uppercase leading-none mb-1">{{ $item->nama_usaha }}</div>
                                <div class="text-[10px] text-gray-500 mb-1 italic">Bidang: {{ $item->jenis_usaha }}</div>
                                <div class="flex gap-1">
                                    <span class="bg-gray-200 px-1 rounded text-[9px]">Sejak {{ $item->tahun_mulai }}</span>
                                    <span class="bg-yellow-100 text-yellow-800 px-1 rounded text-[9px] font-bold">{{ $item->skala_usaha }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 border-r">
                                <div class="text-[11px] leading-snug">
                                    <span class="font-bold text-gray-400 block mb-1">ALAMAT DETAIL:</span>
                                    {{ $item->alamat_usaha }}
                                </div>
                                <div class="mt-2 text-[10px] italic text-blue-500">
                                    {{ $item->kelurahan }}, Kec. {{ $item->kecamatan }}
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r">
                                <div class="text-blue-700 font-bold italic">Rp {{ number_format($item->omzet_bulanan, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-orange-500 mb-1 font-semibold">{{ $item->stabilitas_omzet }}</div>
                                <div class="text-[10px] border-t pt-1">
                                    <span class="block">Tetap: {{ $item->karyawan_tetap }} org</span>
                                    <span class="block">Lepas: {{ $item->karyawan_tidak_tetap }} org</span>
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r bg-gray-50">
                                <div class="mb-2 font-bold text-indigo-600">Level: {{ $item->level_digital }}</div>
                                <div class="text-[10px] leading-relaxed border-l-2 border-indigo-200 pl-2 mb-2">
                                    <span class="font-semibold block text-indigo-400 uppercase text-[8px]">Harapan:</span>
                                    {{ $item->harapan_pelatihan }}
                                </div>
                                <div class="text-[10px] leading-relaxed border-l-2 border-green-200 pl-2">
                                    <span class="font-semibold block text-green-400 uppercase text-[8px]">Target 6 Bln:</span>
                                    {{ $item->target_6_bulan }}
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r font-bold text-blue-800 text-xs bg-blue-50/30">
                                {{ $item->nama_kegiatan }}
                            </td>

                            <td class="px-3 py-4 text-center">
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.pendaftar.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $item->id }}', '{{ $item->nama_lengkap }}')" class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm" title="Buang ke Sampah">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // 1. Fungsi Konfirmasi Hapus
        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Kirim ke Sampah?',
                text: "Data pendaftar " + nama + " akan dipindahkan ke Recycle Bin.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Pindahkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // 2. Notifikasi Berhasil
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif

        // 3. Notifikasi Error
        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
</body> 
</html>