<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelaku Usaha - Kota Madiun</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    
<style>
    /* 1. Pengaturan Dasar Scrollbar & Container */
    [x-cloak] { display: none !important; }
    .table-container {cursor: grab; overflow-x: auto; position: relative; background-color: white; }
    .table-container:active { cursor: grabbing; }
    .table-container::-webkit-scrollbar { height: 8px; }
    .table-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    /* 2. Supaya Teks Bisa Di-copy */
    .table-container td, 
    .table-container th {
        user-select: text !important;
        -webkit-user-select: text !important;
        background-clip: padding-box;
    }

    /* 3. Pengaturan Kolom Sticky */
    .col-sticky-1 {position: sticky !important; left: 0 !important;
        z-index: 20 !important; background-color: #f8fafc !important; 
        border-right: 1px solid #e2e8f0;}

    .col-sticky-2 {
        position: sticky !important;
        left: 51px !important; 
        z-index: 20 !important;
        background-color: #f8fafc !important; 
        box-shadow: 4px 0 6px -4px rgba(0,0,0,0.2);
        border-right: 2px solid #cbd5e1;
    }

    thead th.col-sticky-1, 
    thead th.col-sticky-2 {
        z-index: 30 !important;
        background-color: #f1f5f9 !important; 
    }
</style>
</head>
<body class="bg-slate-50 font-sans text-slate-900" 
      x-data="{ 
          openModalTambah: false, 
          openModalEdit: false,
          searchTerm: '',
          kecamatan: '', 
          kelurahan: '',
          // Data Kelurahan berdasarkan Kota Madiun
          listKelurahan: {
              'Kartoharjo': ['Kanigoro', 'Kelun', 'Kartoharjo', 'Klegen', 'Oro-Oro Ombo', 'Pilangbango', 'Rejomulyo', 'Sukosari', 'Tawangrejo'],
              'Manguharjo': ['Madiun Lor', 'Manguharjo', 'Nambangan Kidul', 'Nambangan Lor', 'Ngegong', 'Pangongangan', 'Patihan', 'Sogaten', 'Winongo'],
              'Taman': ['Banjarejo', 'Demangan', 'Josenan', 'Kejuron', 'Kuncen', 'Mojorejo', 'Manisrejo', 'Pandean', 'Taman']
          }
      }" 
      @set-tambah-modal.window="openModalTambah = $event.detail"
      @set-edit-modal.window="openModalEdit = $event.detail">

    <header class="bg-white border-b px-8 py-4 flex justify-between items-center sticky top-0 z-30">
        <div>
            <h1 class="text-xl font-bold text-indigo-900">Database Pelaku Usaha Kota Madiun</h1>
            <p class="text-sm text-slate-500">Manajemen data investasi dan perizinan</p>
        </div>
        <div class="flex gap-3">
            <button onclick="exportToExcel()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </button>
            <button @click="openModalTambah = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>    
                + Tambah Pelaku Usaha
            </button>
            <a href="{{ route('admin.download-template') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-100 text-sm transition">
                <span>Template</span>
            </a>
            <button onclick="openImportModal()" class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg hover:bg-amber-100 text-sm transition">
                <span>Import</span>
            </button>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-sm font-semibold transition flex items-center shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
        </div>
    </header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-emerald-100">
        <div class="flex items-center">
            <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-xs font-bold text-slate-500 uppercase">Total Investasi</p>
                <h3 class="text-xl font-black text-slate-800">
                    Rp {{ number_format($totalinvestasi ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-blue-100">
        <div class="flex items-center">
            <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-xs font-bold text-slate-500 uppercase">Tenaga Kerja</p>
                <h3 class="text-xl font-black text-slate-800">
                    {{ number_format($totalTenagaKerja ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-indigo-100">
        <div class="flex items-center">
            <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-xs font-bold text-slate-500 uppercase">Pelaku Usaha (NIB Unik)</p>
                <h3 class="text-xl font-black text-slate-800">
                    {{ number_format($totalPelakuUnik ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <div class="flex items-center">
            <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-xs font-bold text-slate-500 uppercase">Total Proyek</p>
                <h3 class="text-xl font-black text-slate-800">
                    {{ number_format($totalSemuaData ?? 0, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>
    <main class="p-8">
        <div class="bg-white p-4 rounded-xl shadow-sm mb-6 border flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[300px]">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Cari Data</label>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Masukkan NIB atau Nama Perusahaan..." class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none bg-slate-50">
            </div>
            <div class="w-48">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kecamatan</label>
                <select id="filterKecamatan" onchange="filterTable()" class="w-full mt-1 px-3 py-2 border rounded-lg bg-slate-50">
                    <option value="">Semua</option>
                    <option value="Kartoharjo">Kartoharjo</option>
                    <option value="Manguharjo">Manguharjo</option>
                    <option value="Taman">Taman</option>
                </select>
            </div>
            <div class="w-48">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tingkat Risiko</label>
                <select id="filterRisiko" onchange="filterTable()" class="w-full mt-1 px-3 py-2 border rounded-lg bg-slate-50">
                    <option value="">Semua</option>
                    <option value="Rendah">Rendah</option>
                    <option value="Menengah Rendah">Menengah Rendah</option>
                    <option value="Menengah Tinggi">Menengah Tinggi</option>
                    <option value="Tinggi">Tinggi</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="table-container select-none">
                <table class="w-full whitespace-nowrap text-left border-collapse" id="dataTable">
                    <thead class="bg-slate-50 border-b">
                        <tr class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="col-sticky-1 p-4 text-center">No</th>
                            <th class="col-sticky-2 p-4">Nama Perusahaan</th>
                            <th class="p-4 border-r">NIB</th>
                            <th class="p-4 border-r">NIK Pemilik</th>
                            <th class="p-4 border-r">Nama Pemilik</th>
                            <th class="p-4">No. Telp</th>
                            <th class="p-4">Email</th>
                            <th class="p-4 border-r">Skala Usaha</th>
                            <th class="p-4 border-r">Jenis Perusahaan</th>
                            <th class="p-4 border-r">Nama Proyek</th>
                            <th class="p-4 border-r">KBLI</th>
                            <th class="p-4 border-r">Uraian KBLI</th>
                            <th class="p-4 border-r">Alamat Usaha</th>
                            <th class="p-4 border-r">Kecamatan</th>
                            <th class="p-4 border-r">Kelurahan</th>
                            <th class="p-4 text-center">Tenaga Kerja</th>
                            <th class="p-4 border-r">Tingkat Risiko</th>
                            <th class="p-4 border-r">Investasi (Rp)</th>
                            <th class="p-4 border-r">Tanggal Terbit</th>
                            <th class="p-4 sticky right-0 bg-slate-50 z-10 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @forelse($data as $item)
                        <tr id="row-{{ $item->id }}" class="hover:bg-slate-50 transition">
                            <td class="col-sticky-1 px-6 py-4 text-center text-gray-500">
                                {{ $loop->iteration }}
                            </td>
                            <td class="col-sticky-2 p-4 border-r bg-white font-bold text-indigo-900">
                                {{ $item->nama_perusahaan }}
                            </td>
                            <td class="p-4 border-r font-mono text-xs">{{ $item->nib }}</td>
                            <td class="p-4 border-r font-mono text-xs">{{ $item->nik }}</td>
                            <td class="p-4 border-r">{{ $item->nama_pemilik }}</td>
                            <td class="p-4 border-r">{{ $item->no_telp }}</td>
                            <td class="p-4 border-r">{{ $item->email }}</td>
                            <td class="p-4 border-r">{{ $item->skala_usaha }}</td>
                            <td class="p-4 border-r">{{ $item->jenis_perusahaan }}</td>
                            <td class="p-4 border-r">{{ $item->nama_proyek }}</td>
                            <td class="p-4 border-r font-bold">{{ $item->kbli }}</td>
                            <td class="p-4 border-r">{{ $item->uraian_kbli }}</td>
                            <td class="p-4 border-r">{{ $item->alamat_usaha }}</td>
                            <td class="p-4 border-r">{{ $item->kecamatan }}</td>
                            <td class="p-4 border-r">{{ $item->kelurahan }}</td>
                            <td class="p-4 border-r">{{ $item->tenaga_kerja }}</td>
                            <td class="p-4 border-r">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-blue-100 text-blue-700">
                                    {{ $item->tingkat_risiko }}
                                </span>
                            </td>
                            <td class="p-4 border-r font-bold text-emerald-600">
                                {{ number_format($item->investasi, 0, ',', '.') }}
                            </td>
                            <td class="p-4 border-r">{{ $item->tgl_terbit }}</td>
                            <td class="px-6 py-4 text-center sticky right-0 bg-white z-10 border-l">
                                <div class="flex justify-center space-x-2">
                                    <button type="button" @click='window.editData(@json($item))' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </button>
                                    <button type="button" onclick="deleteData('{{ $item->id }}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="20" class="p-12 text-center text-slate-400 italic">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

<div x-show="openModalTambah" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4" x-cloak x-transition>
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden flex flex-col">
        <div class="bg-indigo-600 p-4 text-white flex justify-between items-center">
            <h2 class="font-bold text-lg">Tambah Pelaku Usaha Baru</h2>
            <button @click="openModalTambah = false" class="text-white text-2xl font-bold">&times;</button>
        </div>

        <form action="{{ route('pelaku-usaha.store') }}" method="POST" class="flex-1 overflow-y-auto p-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
                <div class="space-y-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                    <h3 class="font-bold text-blue-800 text-sm uppercase italic border-b border-blue-200 pb-1">I. Identitas</h3>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nomor Induk Berusaha (NIB)</label>
                        <input type="text" name="nib" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nomor Induk Keluarga (NIK)</label>
                        <input type="text" name="nik" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nomor Telepon</label>
                        <input type="text" name="no_telp" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Email</label>
                        <input type="text" name="email" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                </div> <div class="space-y-4 bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                    <h3 class="font-bold text-emerald-800 text-sm uppercase italic border-b border-emerald-200 pb-1">II. Perusahaan</h3>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Jenis Perusahaan</label>
                        <select name="jenis_perusahaan" class="w-full border rounded-lg p-2 outline-none">
                                    <option value="-">Pilih Jenis Perusahaan</option>
                                    <option value="Perorangan">Perorangan</option>
                                    <option value="Commanditaire Vennootschap (CV)">Commanditaire Vennootschap (CV)</option>
                                    <option value="Perusahaan Perseorangan (PO)">Perusahaan Perseorangan (PO)</option>
                                    <option value="(PT) Perorangan">(PT) Perorangan</option>
                                    <option value="Persekutuan Firma (Fa / Venootschap Onder Firma)">Persekutuan Firma (Fa / Venootschap Onder Firma)</option>
                                    <option value="Yayasan">Yayasan</option>
                                </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Nama Proyek</label>
                        <input type="text" name="nama_proyek" class="w-full border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Kbli</label>
                        <input type="text" name="kbli" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Uraian Kbli</label>
                        <input type="text" name="uraian_kbli" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                </div> <div class="space-y-4 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                    <h3 class="font-bold text-amber-800 text-sm uppercase italic border-b border-amber-200 pb-1">III. Lokasi & Skala</h3>
                    <div>
    <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Kecamatan</label>
    <select name="kecamatan" 
            x-model="kecamatan" 
            @change="kelurahan = ''" 
            class="w-full border rounded-lg p-2 outline-none">
        <option value="">Pilih Kecamatan</option>
        <option value="Kartoharjo">Kartoharjo</option>
        <option value="Manguharjo">Manguharjo</option>
        <option value="Taman">Taman</option>
    </select>
</div>
<div>
    <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Kelurahan</label>
    <select name="kelurahan" 
            x-model="kelurahan" 
            class="w-full border rounded-lg p-2 outline-none"
            :disabled="!kecamatan">
        <option value="">Pilih Kelurahan</option>
        
        <template x-if="kecamatan">
            <template x-for="item in listKelurahan[kecamatan]" :key="item">
                <option :value="item" x-text="item"></option>
            </template>
        </template>
    </select>
</div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Alamat Usaha</label>
                        <input type="text" name="alamat_usaha" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Tingkat Resiko</label>
                        <select name="tingkat_risiko" class="w-full border rounded-lg p-2 outline-none">
                                    <option value="-">Pilih Tingkat Resiko</option>
                                    <option value="Rendah">Rendah</option>
                                    <option value="Menengah Rendah">Menengah Rendah</option>
                                    <option value="Menengah Tinggi">Menengah Tinggi</option>
                                    <option value="Tinggi">Tinggi</option>
                                </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Skala Usaha</label>
                        <select name="skala_usaha" class="w-full border rounded-lg p-2 outline-none">
                                    <option value="-">Pilih Skala Usaha</option>
                                    <option value="Usaha Mikro">Usaha Mikro</option>
                                    <option value="Usaha Kecil">Usaha Kecil</option>
                                    <option value="Usaha Menengah">Usaha Menengah</option>
                                    <option value="Usaha Besar">Usaha Besar</option>
                                </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Investasi</label>
                        <input type="number" name="investasi" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Jumlah Tenaga Kerja</label>
                        <input type="number" name="tenaga_kerja" class="w-full border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Tanggal Terbit</label>
                        <input type="date" name="tgl_terbit" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    </div>
                </div>
            <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                <button type="button" @click="openModalTambah = false" class="px-6 py-2 text-slate-500 font-bold hover:bg-slate-100 rounded-lg">BATAL</button>
                <button type="submit" class="bg-indigo-600 text-white px-10 py-2 rounded-lg font-bold shadow-lg">SIMPAN DATA</button>
            </div>
        </form>
    </div>
</div>

<div x-show="openModalEdit" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4" x-cloak x-transition>
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden flex flex-col">
        <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
            <h2 class="font-bold text-lg">Edit Pelaku Usaha</h2>
            <button @click="openModalEdit = false" class="text-white text-2xl font-bold">&times;</button>
        </div>

        <form id="formEditAction" method="POST" class="flex-1 overflow-y-auto p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-left">
                
                <div class="space-y-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <h3 class="font-bold text-slate-800 text-sm uppercase italic border-b border-slate-200 pb-1">I. Identitas</h3>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nomor Induk Berusaha (NIB)</label>
                        <input type="text" name="nib" id="edit_nib" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nomor Induk Keluarga (NIK)</label>
                        <input type="text" name="nik" id="edit_nik" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" id="edit_nama_pemilik" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nomor Telepon</label>
                        <input type="text" name="no_telp" id="edit_no_telp" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Email</label>
                        <input type="text" name="email" id="edit_email" class="w-full border-slate-200 border rounded-lg p-2 outline-none" required>
                    </div>
                </div> <div class="space-y-4 bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                    <h3 class="font-bold text-emerald-800 text-sm uppercase italic border-b border-emerald-200 pb-1">II. Perusahaan</h3>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" id="edit_nama_perusahaan" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Jenis Perusahaan</label>
                        <input type="text" name="jenis_perusahaan" id="edit_jenis_perusahaan" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Nama Proyek</label>
                        <input type="text" name="nama_proyek" id="edit_nama_proyek" class="w-full border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Kbli</label>
                        <input type="text" name="kbli" id="edit_kbli" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Uraian Kbli</label>
                        <input type="text" name="uraian_kbli" id="edit_uraian_kbli" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                </div> <div class="space-y-4 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                    <h3 class="font-bold text-amber-800 text-sm uppercase italic border-b border-amber-200 pb-1">III. Lokasi & Skala</h3>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Kecamatan</label>
                        <input type="text" name="kecamatan" id="edit_kecamatan" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Kelurahan</label>
                        <input type="text" name="kelurahan" id="edit_kelurahan" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Alamat Usaha</label>
                        <input type="text" name="alamat_usaha" id="edit_alamat_usaha" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Tingkat Resiko</label>
                        <input type="text" name="tingkat_risiko" id="edit_tingkat_risiko" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Skala Usaha</label>
                        <input type="text" name="skala_usaha" id="edit_skala_usaha" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Investasi</label>
                        <input type="number" name="investasi" id="edit_investasi" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1 uppercase">Jumlah Tenaga Kerja</label>
                        <input type="number" name="tenaga_kerja" id="edit_tenaga_kerja" class="w-full border rounded-lg p-2 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1 uppercase">Tanggal Terbit</label>
                        <input type="date" name="tgl_terbit" id="edit_tgl_terbit" class="w-full border-slate-200 border rounded-lg p-2 outline-none">
                    </div>
                </div> </div> <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                <button type="button" @click="openModalEdit = false" class="px-6 py-2 text-slate-500 font-bold hover:bg-slate-100 rounded-lg">BATAL</button>
                <button type="submit" class="bg-blue-600 text-white px-10 py-2 rounded-lg font-bold shadow-lg">UPDATE DATA</button>
            </div>
        </form>
    </div>
</div>

<div id="importModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-amber-500 p-4 text-white flex justify-between items-center">
            <h3 class="font-bold">Import Data Pelaku Usaha</h3>
            <button onclick="closeImportModal()" class="text-white text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.import-ikm') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File Excel (.xlsx)</label>
                <input type="file" name="file" id="fileInput" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 text-slate-500">BATAL</button>
                <button type="submit" class="bg-amber-500 text-white px-6 py-2 rounded-lg font-bold">IMPORT</button>
            </div>
        </form>
    </div>
</div>

<script>
    /* --- 1. MODAL TAMBAH & EDIT LOGIC --- */
    window.openTambahModal = function() {
        const formTambah = document.querySelector('div[x-show="openModalTambah"] form');
        if (formTambah) formTambah.reset();
        window.dispatchEvent(new CustomEvent('set-tambah-modal', { detail: true }));
    };

    window.editData = function(item) {
        const fillField = (id, value) => {
            const el = document.getElementById(id);
            if (el) {
                el.value = value || (id.includes('tenaga_kerja') || id.includes('investasi') ? 0 : '');
            } else {
                console.warn(`Peringatan: Elemen ID '${id}' tidak ditemukan.`);
            }
        };

        const form = document.getElementById('formEditAction');
        if (form) {
            form.action = '/pelaku-usaha/' + item.id;
        }

        fillField('edit_nib', item.nib);
        fillField('edit_nik', item.nik);
        fillField('edit_nama_perusahaan', item.nama_perusahaan);
        fillField('edit_nama_pemilik', item.nama_pemilik);
        fillField('edit_email', item.email);
        fillField('edit_no_telp', item.no_telp);
        fillField('edit_jenis_perusahaan', item.jenis_perusahaan);
        fillField('edit_kbli', item.kbli);
        fillField('edit_uraian_kbli', item.uraian_kbli);
        fillField('edit_kecamatan', item.kecamatan);
        fillField('edit_kelurahan', item.kelurahan);
        fillField('edit_nama_proyek', item.nama_proyek);
        fillField('edit_tenaga_kerja', item.tenaga_kerja);
        fillField('edit_alamat_usaha', item.alamat_usaha);
        fillField('edit_tingkat_risiko', item.tingkat_risiko);
        fillField('edit_skala_usaha', item.skala_usaha);
        fillField('edit_investasi', item.investasi);
        
        if (item.tgl_terbit) {
            fillField('edit_tgl_terbit', item.tgl_terbit.split(' ')[0]);
        }

        window.dispatchEvent(new CustomEvent('set-edit-modal', { detail: true }));
    };

    /* --- 2. IMPORT MODAL LOGIC --- */
    function openImportModal() {
        const modal = document.getElementById('importModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeImportModal() {
        const modal = document.getElementById('importModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    /* --- 3. FUNGSI HAPUS DATA --- */
    function deleteData(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/pelaku-usaha/' + id; 
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    /* --- 4. FILTER TABLE --- */
function filterTable() {
    // 1. Ambil nilai input
    const searchVal = document.getElementById("searchInput") ? document.getElementById("searchInput").value.toUpperCase() : "";
    const kecVal = document.getElementById("filterKecamatan").value.toUpperCase();
    const risikoVal = document.getElementById("filterRisiko").value.toUpperCase();
    const rows = document.querySelectorAll("tbody tr");

    // 2. Variabel penampung statistik
    let counter = 1;
    let totalinvestasi = 0;
    let totalTK = 0;
    let nibSet = new Set();
    let barisTampak = 0;

    rows.forEach(row => {
        // Lewati jika baris tidak memiliki sel (mencegah error)
        if (row.cells.length < 5) return;

        // 3. Definisi Indeks Kolom Berdasarkan Gambar image_9437f2.png
        const textFull = row.innerText.toUpperCase();
        const textKec = row.cells[13] ? row.cells[13].innerText.toUpperCase().trim() : "";
        const textRisiko = row.cells[16] ? row.cells[16].innerText.toUpperCase().trim() : "";
        const textNIB = row.cells[1] ? row.cells[1].innerText.trim() : "";

        // 4. Logika Pencocokan
        const matchSearch = searchVal === "" || textFull.includes(searchVal);
        const matchKec = kecVal === "" || textKec === kecVal;
        const matchRisiko = risikoVal === "" || textRisiko === risikoVal;

        if (matchSearch && matchKec && matchRisiko) {
            row.style.display = "";
            
            // Update Nomor Urut di Tabel
            row.cells[0].innerText = counter++;

            // 5. Hitung Angka (Indeks 11 = Investasi, Indeks 12 = Tenaga Kerja)
            const invVal = parseInt(row.cells[11].innerText.replace(/[^0-9]/g, '')) || 0;
            const tkVal = parseInt(row.cells[12].innerText.replace(/[^0-9]/g, '')) || 0;

            totalinvestasi += invVal;
            totalTK += tkVal;
            if (textNIB) nibSet.add(textNIB);
            barisTampak++;
        } else {
            row.style.display = "none";
        }
    });

}
/* --- 5. EXPORT EXCEL LOGIC --- */
/* --- 5. EXPORT EXCEL LOGIC --- */
async function exportToExcel() {
    try {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Data Pelaku Usaha');
        
        // 1. Definisikan Kolom Excel sesuai urutan TH Anda
        worksheet.columns = [
            { header: 'No', key: 'no', width: 5 },
            { header: 'Nama Perusahaan', key: 'nama_perusahaan', width: 30 },
            { header: 'NIB', key: 'nib', width: 20 },
            { header: 'NIK Pemilik', key: 'nik', width: 20 },
            { header: 'Nama Pemilik', key: 'nama_pemilik', width: 20 },
            { header: 'No. Telp', key: 'no_telp', width: 15 },
            { header: 'Email', key: 'email', width: 25 },
            { header: 'Skala Usaha', key: 'skala_usaha', width: 15 },
            { header: 'Jenis Perusahaan', key: 'jenis_perusahaan', width: 20 },
            { header: 'Nama Proyek', key: 'nama_proyek', width: 25 },
            { header: 'KBLI', key: 'kbli', width: 10 },
            { header: 'Uraian KBLI', key: 'uraian_kbli', width: 30 },
            { header: 'Alamat Usaha', key: 'alamat_usaha', width: 30 },
            { header: 'Kecamatan', key: 'kecamatan', width: 15 },
            { header: 'Kelurahan', key: 'kelurahan', width: 15 },
            { header: 'Tenaga Kerja', key: 'tenaga_kerja', width: 15 },
            { header: 'Tingkat Risiko', key: 'tingkat_risiko', width: 15 },
            { header: 'Investasi (Rp)', key: 'investasi', width: 20 },
            { header: 'Tanggal Terbit', key: 'tgl_terbit', width: 15 }
        ];

        // Styling Header
        const headerRow = worksheet.getRow(1);
        headerRow.font = { bold: true, color: { argb: 'FFFFFFFF' } };
        headerRow.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF4F46E5' } };

        const rows = document.querySelectorAll("tbody tr");
        let count = 1;

        rows.forEach(row => {
            // Hanya ambil baris yang tidak disembunyikan oleh filter
            if (row.style.display !== "none") {
                const cells = row.querySelectorAll("td");
                if (cells.length > 1) {
                    worksheet.addRow({
                        no: count++,
                        nama_perusahaan: cells[1]?.innerText.trim() || '',
                        nib:             cells[2]?.innerText.trim() || '',
                        nik:             cells[3]?.innerText.trim() || '',
                        nama_pemilik:    cells[4]?.innerText.trim() || '',
                        no_telp:         cells[5]?.innerText.trim() || '',
                        email:           cells[6]?.innerText.trim() || '',
                        skala_usaha:     cells[7]?.innerText.trim() || '',
                        jenis_perusahaan:cells[8]?.innerText.trim() || '',
                        nama_proyek:     cells[9]?.innerText.trim() || '',
                        kbli:            cells[10]?.innerText.trim() || '',
                        uraian_kbli:     cells[11]?.innerText.trim() || '',
                        alamat_usaha:    cells[12]?.innerText.trim() || '',
                        kecamatan:       cells[13]?.innerText.trim() || '',
                        kelurahan:       cells[14]?.innerText.trim() || '',
                        tenaga_kerja:    cells[15]?.innerText.trim() || '',
                        tingkat_risiko:  cells[16]?.innerText.trim() || '',
                        investasi:       cells[17]?.innerText.trim() || '',
                        tgl_terbit:      cells[18]?.innerText.trim() || ''
                    });
                }
            }
        });

        const buffer = await workbook.xlsx.writeBuffer();
        const fileName = `Data_Pelaku_Usaha_${new Date().toISOString().slice(0,10)}.xlsx`;
        saveAs(new Blob([buffer]), fileName);

    } catch (error) {
        console.error("Export failed:", error);
        alert("Gagal mengekspor data: " + error.message);
    }
}

    /* --- 6. TABLE SLIDER DRAG LOGIC --- */
    const slider = document.querySelector('.table-container');
    if(slider) {
        let isDown = false; let startX; let scrollLeft;
        slider.addEventListener('mousedown', (e) => {
            if (['BUTTON', 'A', 'INPUT', 'SVG', 'PATH', 'I'].includes(e.target.tagName)) return;
            isDown = true; startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => isDown = false);
        slider.addEventListener('mouseup', () => isDown = false);
        slider.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    }

    /* --- 7. EVENT LISTENER --- */
    document.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'fileInput') {
             console.log("File terpilih: " + e.target.files[0]?.name);
        }
    });
</script>

@if(session('import_status'))
<div id="modal-import-selesai" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-8 max-w-lg w-full shadow-2xl">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                <i class="fas fa-info text-blue-600 text-2xl"></i>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Import Selesai</h3>
            
            <div class="flex justify-around my-4 p-4 bg-gray-50 rounded-lg">
                <div class="text-center">
                    <p class="text-sm text-gray-500 uppercase">Berhasil</p>
                    <p class="text-2xl font-bold text-green-600">{{ session('jumlah_berhasil') }}</p>
                </div>
                <div class="text-center border-l border-gray-200 pl-8">
                    <p class="text-sm text-gray-500 uppercase">Dilewati</p>
                    <p class="text-2xl font-bold text-red-500">{{ session('jumlah_dilewati') }}</p>
                </div>
            </div>

            @if(session('jumlah_dilewati') > 0)
                <p class="text-sm text-gray-600 mb-2 text-left">Detail data yang dilewati (NIB & KBLI Sama):</p>
                <div class="bg-gray-100 rounded p-4 text-left max-h-40 overflow-y-auto mb-6">
                    <ul class="text-xs text-gray-700 list-decimal pl-4">
                        @foreach(session('list_dilewati') as $info)
                            <li>{{ $info }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button onclick="document.getElementById('modal-import-selesai').remove()" 
                    class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition duration-200">
                OK
            </button>
        </div>
    </div>
</div>
@endif