<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lengkap Pendaftar IKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Optimasi scrollbar untuk tabel lebar */
        .custom-scrollbar::-webkit-scrollbar { height: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-full mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Database Pendaftar IKM Madiun</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-sm font-semibold transition flex items-center shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
                <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md">
                    Total: {{ count($pendaftar) }} Peserta
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @foreach($statistik as $stat)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1 pr-2">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider truncate" title="{{ $stat->nama }}">{{ $stat->nama }}</h4>
                        <p class="text-2xl font-black text-blue-600">{{ $stat->terisi }} <span class="text-sm text-gray-400 font-normal">/ {{ $stat->kuota }}</span></p>
                    </div>
                    <div class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-[10px] font-bold shrink-0">
                        {{ $stat->persentase }}%
                    </div>
                </div>
                
                <div class="w-full bg-gray-100 rounded-full h-1.5 mb-2">
                    <div class="bg-blue-600 h-1.5 rounded-full transition-all duration-700" style="width: {{ $stat->persentase }}%"></div>
                </div>
                
                <p class="text-[10px] {{ $stat->sisa <= 5 ? 'text-red-500 font-bold' : 'text-gray-500' }}">
                    {!! $stat->sisa <= 0 ? '<i class="fas fa-exclamation-triangle mr-1"></i> KUOTA HABIS' : 'Sisa Kuota: ' . $stat->sisa . ' Kursi' !!}
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
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-bold transition flex items-center">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.pendaftar') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg text-sm font-bold transition">Reset</a>
                    </div>
                </form>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.kegiatan.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                        <i class="fas fa-cog mr-2"></i> Pengaturan Kegiatan
                    </a>
                    <a href="{{ route('admin.recycle') }}" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center gap-2 transition">
                        <i class="fas fa-trash-alt"></i> <span>Sampah</span>
                    </a>
                    <a href="{{ route('admin.pendaftar.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm flex items-center gap-2 transition">
                        <i class="fas fa-file-excel"></i> <span>Export Excel</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-blue-600 text-white text-[11px] uppercase tracking-wider">
                            <th class="px-3 py-4 border-r border-blue-500 whitespace-nowrap">No</th>
                            <th class="px-3 py-4 border-r border-blue-500 whitespace-nowrap">Pratinjau KTP</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Biodata Peserta</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Legalitas (NIK/NIB)</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Kontak & Sosmed</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Detail Usaha</th>
                            <th class="px-6 py-4 border-r border-blue-500 text-left whitespace-nowrap">Alamat Lengkap Usaha</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Finansial & SDM</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Digitalisasi & Harapan</th>
                            <th class="px-3 py-4 border-r border-blue-500 text-left whitespace-nowrap">Kegiatan Pelatihan</th>
                            <th class="px-3 py-4 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-[12px] divide-y divide-gray-200">
                        @foreach($pendaftar as $index => $item)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-3 py-4 text-center font-bold bg-gray-50 border-r">{{ $index + 1 }}</td>
                            
                            <td class="px-3 py-4 border-r text-center">
                                @if($item->foto_ktp)
                                    <div class="flex flex-col items-center gap-2">
                                        <img src="{{ $item->foto_ktp }}" 
                                             class="h-14 w-24 object-cover rounded shadow border bg-gray-200 cursor-zoom-in"
                                             onclick="window.open(this.src)"
                                             onerror="this.onerror=null;this.src='https://placehold.co/100x60/e2e8f0/475569?text=Refused';">
                                        <a href="{{ $item->foto_ktp }}" target="_blank" class="text-[9px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded hover:bg-blue-200 font-bold whitespace-nowrap">
                                            LIHAT KTP <i class="fas fa-external-link-alt ml-1"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-red-400 italic">Data Kosong</span>
                                @endif
                            </td>

                            <td class="px-3 py-4 border-r min-w-[150px]">
                                <div class="font-bold text-gray-900 leading-tight uppercase">{{ $item->nama_lengkap }}</div>
                                <div class="text-gray-500 mt-1"><i class="fas fa-venus-mars mr-1 text-[10px]"></i> {{ $item->jenis_kelamin }}</div>
                                <div class="text-[10px] bg-gray-100 inline-block px-1.5 py-0.5 mt-1 rounded text-gray-600"><i class="fas fa-calendar-alt mr-1"></i> {{ $item->tanggal_lahir }}</div>
                            </td>

                            <td class="px-3 py-4 border-r font-mono tracking-tighter text-[11px]">
                                <div class="mb-1 p-1 bg-blue-50 rounded"><span class="text-gray-400 font-sans">NIK:</span> {{ $item->nik }}</div>
                                <div class="p-1 bg-green-50 rounded"><span class="text-gray-400 font-sans">NIB:</span> {{ $item->nib }}</div>
                            </td>

                            <td class="px-3 py-4 border-r min-w-[140px]">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->whatsapp) }}" target="_blank" class="flex items-center gap-1 text-green-600 font-bold hover:underline mb-1">
                                    <i class="fab fa-whatsapp text-sm"></i> {{ $item->whatsapp }}
                                </a>
                                <div class="text-gray-500 break-all flex items-center gap-1 text-[11px]">
                                    <i class="far fa-envelope text-[10px]"></i> {{ $item->email }}
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r min-w-[140px]">
                                <div class="font-bold text-blue-800 uppercase leading-none mb-1">{{ $item->nama_usaha }}</div>
                                <div class="text-[10px] text-gray-500 mb-1 italic">Bidang: {{ $item->jenis_usaha }}</div>
                                <div class="flex flex-wrap gap-1">
                                    <span class="bg-gray-200 px-1 rounded text-[9px]">Mulai {{ $item->tahun_mulai }}</span>
                                    <span class="bg-yellow-100 text-yellow-800 px-1 rounded text-[9px] font-bold">{{ $item->skala_usaha }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 border-r min-w-[200px]">
                                <div class="text-[11px] leading-snug">
                                    <span class="font-bold text-gray-400 block mb-1 uppercase text-[9px]">Alamat Detail:</span>
                                    {{ $item->alamat_usaha }}
                                </div>
                                <div class="mt-2 text-[10px] font-semibold text-blue-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $item->kelurahan }}, Kec. {{ $item->kecamatan }}
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r">
                                <div class="text-blue-700 font-black text-sm">Rp {{ number_format($item->omzet_bulanan, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-orange-600 mb-1 font-bold">{{ $item->stabilitas_omzet }}</div>
                                <div class="text-[10px] border-t border-gray-100 pt-1 mt-1">
                                    <span class="block"><i class="fas fa-user-check mr-1 text-[9px]"></i> Tetap: {{ $item->karyawan_tetap }}</span>
                                    <span class="block"><i class="fas fa-user-clock mr-1 text-[9px]"></i> Lepas: {{ $item->karyawan_tidak_tetap }}</span>
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r bg-gray-50/50 min-w-[180px]">
                                <div class="mb-2 font-bold text-indigo-700">Level: {{ $item->level_digital }}</div>
                                <div class="text-[10px] leading-relaxed border-l-2 border-indigo-300 pl-2 mb-2 italic">
                                    <span class="font-bold block text-indigo-500 not-italic uppercase text-[8px]">Harapan:</span>
                                    "{{ $item->harapan_pelatihan }}"
                                </div>
                                <div class="text-[10px] leading-relaxed border-l-2 border-green-300 pl-2 italic">
                                    <span class="font-bold block text-green-500 not-italic uppercase text-[8px]">Target 6 Bln:</span>
                                    "{{ $item->target_6_bulan }}"
                                </div>
                            </td>

                            <td class="px-3 py-4 border-r bg-blue-50/30">
                                <span class="text-blue-800 font-bold text-[11px] leading-tight block">
                                    <i class="fas fa-graduation-cap mr-1 text-blue-400"></i> {{ $item->nama_kegiatan }}
                                </span>
                            </td>

                            <td class="px-3 py-4 text-center">
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.pendaftar.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $item->id }}', '{{ $item->nama_lengkap }}')" class="bg-red-50 text-red-600 p-2.5 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm group" title="Buang ke Sampah">
                                        <i class="fas fa-trash-can group-hover:scale-110 transition-transform"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(count($pendaftar) == 0)
                <div class="text-center py-12">
                    <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Tidak ada data pendaftar ditemukan.</p>
                </div>
            @endif
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
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Pindahkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
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
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#3b82f6'
            });
        @endif
    </script>
</body> 
</html>