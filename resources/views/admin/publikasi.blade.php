@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Publikasi & Berita</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
            + Tambah Berita/Kegiatan
        </button> 
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4 font-bold text-slate-600">Gambar</th>
                    <th class="p-4 font-bold text-slate-600">Judul</th>
                    <th class="p-4 font-bold text-slate-600">Tanggal</th>
                    <th class="p-4 font-bold text-slate-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publikasi as $row)
                <tr class="border-b hover:bg-slate-50 transition">
                    <td class="p-4">
                        <img src="{{ $row->gambar }}" class="w-20 h-12 object-cover rounded shadow-sm" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                    </td>
                    <td class="p-4">
                        <span class="font-semibold text-slate-700">{{ $row->judul }}</span>
                        <br>
                        <span class="text-xs text-indigo-500 font-medium italic">{{ $row->status }}</span>
                    </td>
                    <td class="p-4 text-slate-600 text-sm">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="p-4 text-center">
                        <form action="{{ route('admin.publikasi.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center justify-center gap-1 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400">Belum ada data publikasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg p-6">
        <form action="{{ route('admin.publikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3 class="text-xl font-bold mb-4">Input Berita Baru</h3>
            <div class="space-y-4">
                <input type="text" name="judul" placeholder="Judul Berita" class="w-full border p-2 rounded" required>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" required>
                <input type="text" name="waktu" placeholder="Contoh: 08:00 - Selesai" class="w-full border p-2 rounded">
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Informasi">Informasi</option>
                    <option value="Belum Dimulai">Belum Dimulai</option>
                    <option value="Selesai">Selesai</option>
                </select>
                <textarea name="deskripsi" placeholder="Deskripsi Singkat" class="w-full border p-2 rounded" rows="3" required></textarea>
                <input type="file" name="gambar" class="w-full border p-2 rounded" required>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="bg-slate-200 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan & Publikasikan</button>
            </div>
        </form>
    </div>
</div>
<script>
    window.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.getElementById('modalTambah').classList.add('hidden');
        }
    });
</script>
@endsection