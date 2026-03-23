@extends('layouts.admin') {{-- PASTIKAN FILE INI ADA DI resources/views/layouts/admin.blade.php --}}

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 border-l-4 border-blue-600 pl-4">Pengaturan Kegiatan Pelatihan</h2>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold flex items-center gap-2 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kegiatan
        </button>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-blue-600 text-white text-[11px] uppercase tracking-wider">
                        <th class="px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-left">Nama & Sub Pelaksana</th>
                        <th class="px-4 py-3 text-left">Jadwal & Tempat</th>
                        <th class="px-4 py-3 text-center">Kuota</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    {{-- Proteksi @forelse jika data kosong --}}
                    @forelse($kegiatan as $index => $k)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-blue-800">{{ $k->nama_kegiatan }}</div>
                            <div class="text-xs text-gray-500 italic">{{ $k->sub_pelaksana ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs">📅 {{ $k->tgl_mulai }} s/d {{ $k->tgl_selesai }}</div>
                            <div class="text-xs text-red-500 font-semibold">📍 {{ $k->tempat_kegiatan }}</div>
                        </td>
                        <td class="px-4 py-3 text-center font-bold text-green-600">{{ $k->kuota_peserta }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick='editKegiatan(@json($k))' class="bg-yellow-100 text-yellow-600 p-2 rounded hover:bg-yellow-600 hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.kegiatan.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-100 text-red-600 p-2 rounded hover:bg-red-600 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-400 italic">Belum ada data kegiatan pelatihan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TETAP SAMA DENGAN OPTIMASI TRANSISI --}}
<div id="modalKegiatan" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 transition-opacity">
    <div class="bg-white rounded-xl w-full max-w-2xl p-6 shadow-2xl transform transition-all">
        <h3 id="modalTitle" class="text-xl font-bold mb-4">Tambah Kegiatan Baru</h3>
        <form id="formKegiatan" action="{{ route('admin.kegiatan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="kegiatan_id">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Sub Pelaksana</label>
                    <input type="text" name="sub_pelaksana" id="sub_pelaksana" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Kuota</label>
                    <input type="number" name="kuota_peserta" id="kuota_peserta" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" id="tgl_mulai" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" id="tgl_selesai" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Tempat Kegiatan</label>
                    <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="col-span-2">
                    <label class="text-xs font-bold text-gray-500 uppercase">Deskripsi</label>
                    <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" rows="3" class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm font-bold transition-all">Batal</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('formKegiatan').reset();
        document.getElementById('kegiatan_id').value = '';
        document.getElementById('modalTitle').innerText = 'Tambah Kegiatan Baru';
        document.getElementById('modalKegiatan').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalKegiatan').classList.add('hidden');
    }

    function editKegiatan(data) {
        document.getElementById('modalTitle').innerText = 'Edit Kegiatan';
        document.getElementById('kegiatan_id').value = data.id;
        document.getElementById('nama_kegiatan').value = data.nama_kegiatan;
        document.getElementById('sub_pelaksana').value = data.sub_pelaksana;
        document.getElementById('kuota_peserta').value = data.kuota_peserta;
        document.getElementById('tgl_mulai').value = data.tgl_mulai;
        document.getElementById('tgl_selesai').value = data.tgl_selesai;
        document.getElementById('tempat_kegiatan').value = data.tempat_kegiatan;
        document.getElementById('deskripsi_kegiatan').value = data.deskripsi_kegiatan;
        document.getElementById('modalKegiatan').classList.remove('hidden');
    }
</script>
@endsection