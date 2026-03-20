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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* 1. Pengaturan Dasar Scrollbar & Container */
    [x-cloak] { display: none !important; }
    .table-container {
        cursor: grab;
        overflow-x: auto;
        position: relative;
        background-color: white;
    }
    .table-container:active { cursor: grabbing; }
    .table-container::-webkit-scrollbar { height: 8px; }
    .table-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    /* 2. Supaya Teks Bisa Di-copy */
    .table-container td, 
    .table-container th {
        user-select: text !important;
        -webkit-user-select: text !important;
        background-clip: padding-box; /* Mencegah warna bocor ke border */
    }

    /* 3. Pengaturan Kolom Sticky (Nomor) */
    .col-sticky-1 {
        position: sticky !important;
        left: 0 !important;
        z-index: 20 !important;
        background-color: #f8fafc !important; /* bg-slate-50 */
        border-right: 1px solid #e2e8f0;
    }

    /* 4. Pengaturan Kolom Sticky (Nama Perusahaan) */
    .col-sticky-2 {
        position: sticky !important;
        left: 51px !important; /* Sesuaikan dengan lebar kolom No */
        z-index: 20 !important;
        background-color: #f8fafc !important; /* bg-slate-50 */
        box-shadow: 4px 0 6px -4px rgba(0,0,0,0.2);
        border-right: 2px solid #cbd5e1;
    }

    /* 5. Khusus Header agar selalu di atas saat scroll bawah */
    thead th.col-sticky-1, 
    thead th.col-sticky-2 {
        z-index: 30 !important;
        background-color: #f1f5f9 !important; /* Lebih gelap dikit agar beda */
    }
</style>
</head>
<body class="bg-slate-50 font-sans text-slate-900">

<div x-data="{ 
        openModal: false, 
        modalTitle: 'Tambah Pelaku Usaha', 
        formAction: '' 
     }"
     @set-modal.window="
        openModal = $event.detail.open; 
        modalTitle = $event.detail.title; 
        formAction = $event.detail.action;
     ">
    
    <header class="bg-white border-b px-8 py-4 flex justify-between items-center sticky top-0 z-30">
        <div>
            <h1 class="text-xl font-bold text-indigo-900">Database Pelaku Usaha Kota Madiun</h1>
            <p class="text-sm text-slate-500">Manajemen data investasi dan perizinan</p>
        </div>
        <div class="flex gap-3">
            <button onclick="exportToExcel()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export Excel
            </button>
            <button @click="openTambahModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm transition">
                + Tambah Pelaku Usaha
            </button>
        </div>
        <div class="flex flex-wrap gap-2">
    <a href="{{ route('admin.download-template') }}" 
       class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-100 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        <span>Download Template</span>
    </a>

    <button onclick="openImportModal()" 
            class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg hover:bg-amber-100 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
        <span>Import Excel</span>
    </button>
</div>
    </header>

    <main class="p-8">
        <div class="bg-white p-4 rounded-xl shadow-sm mb-6 border flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[300px]">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Cari Data</label>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Masukkan NIB atau Nama Perusahaan..." class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-slate-50">
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
                    <option value="Menengah">Menengah</option>
                    <option value="Tinggi">Tinggi</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="table-container overflow-x-auto select-none cursor-grab active:cursor-grabbing">
                <table class="w-full whitespace-nowrap text-left border-collapse">
                    <thead class="bg-slate-50 border-b">
                        <tr class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="col-sticky-1 p-4 text-center">No</th>
                            <th class="col-sticky-2 p-4">Nama Perusahaan</th>
                            <th class="p-4 border-r">NIB</th>
                            <th class="p-4 border-r">NIK Pemilik</th>
                            <th class="p-4 border-r">Nama Pemilik</th>
                            <th class="p-4 border-r">Skala Usaha</th>
                            <th class="p-4 border-r">Jenis Perusahaan</th>
                            <th class="p-4 border-r">Nama Proyek</th>
                            <th class="p-4 border-r">Kecamatan</th>
                            <th class="p-4 border-r">Kelurahan</th>
                            <th class="p-4 border-r">Alamat Usaha</th>
                            <th class="p-4 border-r">KBLI</th>
                            <th class="p-4 border-r">Uraian KBLI</th>
                            <th class="p-4 border-r">Tingkat Risiko</th>
                            <th class="p-4 border-r">Investasi (Rp)</th>
                            <th class="p-4 border-r">Tenaga Kerja</th>
                            <th class="p-4 border-r">No. Telp</th>
                            <th class="p-4 border-r">Email</th>
                            <th class="p-4 border-r">Tgl Terbit</th>
                            <th class="p-4 sticky right-0 bg-slate-50 z-10 text-center">Aksi</th>
                        </tr>
                    </thead>
<tbody class="divide-y text-sm">
    @forelse($data as $item)
    <tr id="row-{{ $item->id }}" class="hover:bg-slate-50 transition">
        
        <td class="col-sticky-1 px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
        </td>

        <td class="col-sticky-2 p-4 border-r bg-white font-bold text-indigo-900">
            {{ $item->nama_perusahaan }}
        </td>

        <td class="p-4 border-r font-mono text-xs">{{ $item->nib }}</td>
        <td class="p-4 border-r font-mono text-xs">{{ $item->nik }}</td>
        <td class="p-4 border-r">{{ $item->nama_pemilik }}</td>
        <td class="p-4 border-r">{{ $item->skala_usaha }}</td>
        <td class="p-4 border-r">{{ $item->jenis_perusahaan }}</td>
        <td class="p-4 border-r">{{ $item->nama_proyek }}</td>
        <td class="p-4 border-r">{{ $item->kecamatan }}</td>
        <td class="p-4 border-r">{{ $item->kelurahan }}</td>
        <td class="p-4 border-r max-w-xs overflow-hidden text-ellipsis">{{ $item->alamat_usaha }}</td>
        <td class="p-4 border-r font-bold">{{ $item->kbli }}</td>
        <td class="p-4 border-r max-w-xs overflow-hidden text-ellipsis">{{ $item->uraian_kbli }}</td>
        <td class="p-4 border-r">
            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-blue-100 text-blue-700">
                {{ $item->tingkat_risiko }}
            </span>
        </td>
        <td class="p-4 border-r font-bold text-emerald-600">
            {{ number_format($item->investasi, 0, ',', '.') }}
        </td>
        <td class="p-4 border-r text-center">{{ $item->tenaga_kerja }}</td>
        <td class="p-4 border-r">{{ $item->no_telp }}</td>
        <td class="p-4 border-r">{{ $item->email }}</td>
        <td class="p-4 border-r">
            {{ $item->tgl_terbit ? \Carbon\Carbon::parse($item->tgl_terbit)->format('d/m/Y') : '-' }}
        </td>

        <td class="p-4 sticky right-0 bg-white z-10 border-l shadow-[-5px_0_10px_-5px_rgba(0,0,0,0.1)]">
            <div class="flex items-center justify-center gap-3">
                <button onclick="editData({{ json_encode($item) }})" 
                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" 
                        title="Edit Data">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </button>

                <button onclick="deleteData({{ $item->id }}, '{{ $item->nama_perusahaan }}')" 
                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                        title="Hapus Data">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="20" class="p-12 text-center text-slate-400 italic">Belum ada data.</td>
    </tr>
    @endforelse
</tbody>
    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" @click.away="openModal = false">
            <div class="p-6 border-b flex justify-between items-center sticky top-0 bg-white z-20">
                <h2 class="text-xl font-bold" x-text="modalTitle"></h2>
                <button @click="openModal = false" class="text-slate-400 hover:text-slate-600 text-2xl">&times;</button>
            </div>
            
            <form :action="formAction" method="POST" id="mainForm" class="p-6">
                @csrf
                <div id="methodField"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="space-y-4 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                        <h3 class="font-bold text-blue-800 text-sm uppercase tracking-wider italic">I. Identitas</h3>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">NIB (13 Digit)</label>
                            <input type="text" name="nib" maxlength="13" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">NIK Pemilik (16 Digit)</label>
                            <input type="text" name="nik" maxlength="16" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nama Pemilik</label>
                            <input type="text" name="nama_pemilik" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nomor Telepon</label>
                            <input type="text" name="no_telp" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Email Aktif</label>
                            <input type="email" name="email" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="space-y-4 bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                        <h3 class="font-bold text-emerald-800 text-sm uppercase tracking-wider italic">II. Perusahaan & Proyek</h3>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Jenis Perusahaan</label>
                            <input type="text" name="jenis_perusahaan" placeholder="Contoh: PT, CV" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nama Proyek</label>
                            <input type="text" name="nama_proyek" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">KBLI (5 Digit)</label>
                            <input type="text" name="kbli" maxlength="5" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Uraian KBLI</label>
                            <textarea name="uraian_kbli" rows="2" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:outline-none focus:ring-emerald-500"></textarea>
                        </div>
                    </div>

                    <div class="space-y-4 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                        <h3 class="font-bold text-amber-800 text-sm uppercase tracking-wider italic">III. Lokasi & Skala</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Kecamatan</label>
                                <select name="kecamatan" class="w-full border rounded-lg p-2.5 focus:outline-none">
                                    <option>Kartoharjo</option>
                                    <option>Manguharjo</option>
                                    <option>Taman</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Kelurahan</label>
                                <input type="text" name="kelurahan" class="w-full border rounded-lg p-2.5 focus:outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Alamat Lengkap</label>
                            <textarea name="alamat_usaha" rows="2" class="w-full border rounded-lg p-2.5 focus:outline-none" required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Skala Usaha</label>
                                <select name="skala_usaha" class="w-full border rounded-lg p-2.5 focus:outline-none">
                                    <option>Mikro</option>
                                    <option>Kecil</option>
                                    <option>Menengah</option>
                                    <option>Besar</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Risiko</label>
                                <select name="tingkat_risiko" class="w-full border rounded-lg p-2.5 focus:outline-none">
                                    <option>Rendah</option>
                                    <option>Menengah Rendah</option>
                                    <option>Menengah Tinggi</option>
                                    <option>Tinggi</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Investasi (Rp)</label>
                            <input type="number" name="investasi" class="w-full border rounded-lg p-2.5 font-bold text-emerald-700 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Tenaga Kerja</label>
                            <input type="number" name="tenaga_kerja" class="w-full border rounded-lg p-2.5 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Tgl Terbit</label>
                            <input type="date" name="tgl_terbit" class="w-full border rounded-lg p-2.5 focus:outline-none" required>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t pt-5">
                    <button type="button" @click="openModal = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-lg transition uppercase">Batal</button>
                    <button type="submit" class="px-10 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition uppercase">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="importModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-800">Import Data Pelaku Usaha</h3>
            <button onclick="closeImportModal()" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>
        
        <form action="{{ route('admin.import-ikm') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="border-2 border-dashed border-slate-200 rounded-lg p-8 text-center hover:border-indigo-400 transition-colors">
                <input type="file" name="file" id="fileInput" class="hidden" accept=".xlsx, .xls" required>
                <label for="fileInput" class="cursor-pointer">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="text-sm text-slate-600">Klik untuk pilih file atau seret file ke sini</p>
                    <p class="text-xs text-slate-400 mt-1">Hanya file .xlsx atau .xls</p>
                    <div id="fileName" class="mt-3 text-sm font-semibold text-indigo-600"></div>
                </label>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="button" onclick="closeImportModal()" class="flex-1 py-2 text-slate-600 font-medium">Batal</button>
                <button type="submit" class="flex-1 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 shadow-lg">Upload Sekarang</button>
            </div>
        </form>
    </div>
</div>
<script>
    function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}

// Menampilkan nama file saat dipilih
document.getElementById('fileInput').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : '';
    document.getElementById('fileName').textContent = fileName;
});
    // 1. MODAL TAMBAH
    function openTambahModal() {
        const form = document.getElementById('mainForm');
        if(form) form.reset();
        document.getElementById('methodField').innerHTML = ''; 
        
        window.dispatchEvent(new CustomEvent('set-modal', {
            detail: { title: 'Tambah Pelaku Usaha', action: "{{ route('pelaku-usaha.store') }}", open: true }
        }));
    }

    // 2. FUNGSI EDIT DATA
function editData(item) {
    const form = document.getElementById('mainForm');
    const methodField = document.getElementById('methodField');

    if(methodField) {
        methodField.innerHTML = '@method("PUT")'; // Gunakan directive Laravel
    }

    if (form) {
        form.reset();
        // Mengisi data ke input form
        Object.keys(item).forEach(key => {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) input.value = item[key];
        });
    }

    window.dispatchEvent(new CustomEvent('set-modal', {
        detail: {
            title: 'Edit Data: ' + item.nama_perusahaan,
            // Gunakan template literal yang benar
            action: "{{ url('/pelaku-usaha/update') }}/" + item.id, 
            open: true
        }
    }));
}

    // 3. FUNGSI HAPUS DATA
    function deleteData(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/pelaku-usaha/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.getElementById(`row-${id}`);
                        if(row) {
                            row.classList.add('opacity-0');
                            setTimeout(() => row.remove(), 300);
                        }
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                    }
                });
            }
        });
    }

    // 4. FILTER TABLE
    function filterTable() {
        const searchVal = document.getElementById("searchInput").value.toUpperCase();
        const kecVal = document.getElementById("filterKecamatan").value.toUpperCase();
        const risikoVal = document.getElementById("filterRisiko").value.toUpperCase();
        
        const rows = document.querySelectorAll("tbody tr:not(.empty-row)");

        rows.forEach(row => {
            const rowText = row.innerText.toUpperCase();
            const matchSearch = rowText.includes(searchVal);
            const matchKec = kecVal === "" || rowText.includes(kecVal);
            const matchRisiko = risikoVal === "" || rowText.includes(risikoVal);

            row.style.display = (matchSearch && matchKec && matchRisiko) ? "" : "none";
        });
    }

    // 5. EXPORT EXCEL
    async function exportToExcel() {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Data Pelaku Usaha');

        worksheet.columns = [
            { header: 'No', key: 'no', width: 5 },
            { header: 'Nama Perusahaan', key: 'nama_perusahaan', width: 30 },
            { header: 'NIB', key: 'nib', width: 20 },
            { header: 'NIK Pemilik', key: 'nik', width: 20 },
            { header: 'Nama Pemilik', key: 'nama_pemilik', width: 25 },
            { header: 'Skala Usaha', key: 'skala', width: 15 },
            { header: 'Jenis Perusahaan', key: 'jenis', width: 20 },
            { header: 'Nama Proyek', key: 'proyek', width: 25 },
            { header: 'Kecamatan', key: 'kecamatan', width: 20 },
            { header: 'Kelurahan', key: 'kelurahan', width: 20 },
            { header: 'Alamat Usaha', key: 'alamat', width: 40 },
            { header: 'KBLI', key: 'kbli', width: 10 },
            { header: 'Uraian KBLI', key: 'uraian_kbli', width: 40 },
            { header: 'Tingkat Risiko', key: 'risiko', width: 15 },
            { header: 'Investasi (Rp)', key: 'investasi', width: 20 },
            { header: 'Tenaga Kerja', key: 'tenaga', width: 15 },
            { header: 'No. Telp', key: 'telp', width: 15 },
            { header: 'Email', key: 'email', width: 25 },
            { header: 'Tgl Terbit', key: 'tgl', width: 15 }
        ];

        const headerRow = worksheet.getRow(1);
        headerRow.font = { bold: true, color: { argb: 'FFFFFFFF' } };
        headerRow.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF4F46E5' } };

        const rows = document.querySelectorAll("tbody tr");
        let count = 1;

        rows.forEach(row => {
            if (row.style.display !== "none" && !row.classList.contains('empty-row')) {
                const cells = row.querySelectorAll("td");
                worksheet.addRow({
                    no: count++,
                    nama_perusahaan: cells[1]?.innerText.trim(),
                    nib: cells[2]?.innerText.trim(),
                    nik: cells[3]?.innerText.trim(),
                    nama_pemilik: cells[4]?.innerText.trim(),
                    skala: cells[5]?.innerText.trim(),
                    jenis: cells[6]?.innerText.trim(),
                    proyek: cells[7]?.innerText.trim(),
                    kecamatan: cells[8]?.innerText.trim(),
                    kelurahan: cells[9]?.innerText.trim(),
                    alamat: cells[10]?.innerText.trim(),
                    kbli: cells[11]?.innerText.trim(),
                    uraian_kbli: cells[12]?.innerText.trim(),
                    risiko: cells[13]?.innerText.trim(),
                    investasi: cells[14]?.innerText.trim(),
                    tenaga: cells[15]?.innerText.trim(),
                    telp: cells[16]?.innerText.trim(),
                    email: cells[17]?.innerText.trim(),
                    tgl: cells[18]?.innerText.trim()
                });
            }
        });

        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        saveAs(blob, `Data_Pelaku_Usaha_${new Date().toISOString().slice(0,10)}.xlsx`);
    }

// 6. SLIDER LOGIC (Optimized)
const slider = document.querySelector('.table-container');
if(slider) {
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        // Jangan aktifkan drag jika yang diklik adalah input atau tombol
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target.tagName === 'INPUT') return;
        
        isDown = true;
        slider.classList.add('active');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.style.cursor = 'grab';
    });

    slider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        
        // Hitung seberapa jauh kursor bergerak
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; 

        // Jika pergerakan kursor lebih dari 5 pixel, baru jalankan geser tabel
        if (Math.abs(x - startX) > 5) {
            e.preventDefault(); // Ini yang mencegah blok teks, kita matikan hanya saat menggeser
            slider.scrollLeft = scrollLeft - walk;
            slider.style.cursor = 'grabbing';
        }
    });
}
</script>
@if(session('warning_duplicates'))
<script>
    Swal.fire({
        title: 'Import Selesai (Beberapa Dilewati)',
        html: `
            <div class="text-left">
                <p class="text-sm font-semibold text-red-600 mb-2">
                    {{ count(session('warning_duplicates')) }} Data TIDAK diimport karena NIB & KBLI sudah ada:
                </p>
                <div class="bg-gray-50 p-3 rounded border max-h-60 overflow-y-auto text-xs font-mono leading-relaxed">
                    <ul class="list-decimal ml-5 space-y-1 text-gray-700">
                        @foreach(session('warning_duplicates') as $dup)
                            <li class="border-b border-gray-200 pb-1">{{ $dup }}</li>
                        @endforeach
                    </ul>
                </div>
                <p class="text-[10px] mt-2 text-gray-400">*Sistem hanya mengizinkan satu kombinasi NIB & KBLI yang unik.</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#4f46e5',
        width: '600px' // Kita perlebar sedikit popup-nya agar tidak sesak
    });
</script>
@endif

</body>
</html>