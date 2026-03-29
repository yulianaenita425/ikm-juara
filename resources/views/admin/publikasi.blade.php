@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800 border-l-4 border-indigo-600 pl-4">Manajemen Publikasi & Berita</h2>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow-md font-bold">
            + Tambah Berita/Kegiatan
        </button> 
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="p-4 font-bold text-slate-600">Gambar</th>
                    <th class="p-4 font-bold text-slate-600">Judul & Status Tampil</th>
                    <th class="p-4 font-bold text-slate-600">Tanggal</th>
                    <th class="p-4 font-bold text-slate-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($publikasi as $row)
                <tr class="border-b hover:bg-slate-50 transition">
                    <td class="p-4">
                        <img src="{{ $row->gambar }}" class="w-20 h-12 object-cover rounded shadow-sm border" onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                    </td>
                    <td class="p-4">
                        <span class="font-semibold text-slate-700">{{ $row->judul }}</span>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[10px] px-2 py-0.5 bg-indigo-100 text-indigo-600 rounded font-bold uppercase">{{ $row->status }}</span>
                            @if($row->is_active)
                                <span class="text-[10px] px-2 py-0.5 bg-green-100 text-green-700 rounded font-bold uppercase">● Aktif di Web</span>
                            @else
                                <span class="text-[10px] px-2 py-0.5 bg-red-100 text-red-700 rounded font-bold uppercase">○ Draft / Sembunyi</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-4 text-slate-600 text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-3">
                            {{-- Form Toggle Status --}}
<form action="{{ route('admin.publikasi.toggle', $row->id) }}" method="POST">
    @csrf 
    @method('PATCH')
    <button type="submit" 
        class="{{ $row->is_active ? 'text-amber-500 hover:text-amber-700' : 'text-emerald-500 hover:text-emerald-700' }} transition-colors focus:outline-none"
        title="{{ $row->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
        
        @if($row->is_active)
            {{-- Icon Mata Coret --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            </svg>
        @else
            {{-- Icon Mata Terbuka --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        @endif
    </button>
</form>
                            <form action="{{ route('admin.publikasi.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center gap-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400 italic">Belum ada data publikasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-2xl">
        <form action="{{ route('admin.publikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3 class="text-xl font-bold mb-4 text-slate-800">Input Berita Baru</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Judul Berita</label>
                    <input type="text" name="judul" placeholder="Masukkan judul..." class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Tipe Konten</label>
                        <select name="status" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Informasi">Informasi</option>
                            <option value="Belum Dimulai">Belum Dimulai</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Tampilkan Langsung?</label>
                    <select name="is_active" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="1">Ya, Publikasikan Sekarang</option>
                        <option value="0">Tidak, Simpan Sebagai Draft</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Deskripsi Singkat</label>
                    <textarea name="deskripsi" placeholder="Apa inti beritanya?" class="w-full border p-2 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500" rows="3" required></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Gambar Utama</label>
                    <input type="file" name="gambar" class="w-full border p-2 rounded-lg" required>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="bg-slate-200 hover:bg-slate-300 px-4 py-2 rounded-lg font-bold transition">Batal</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold transition shadow-lg">Simpan Publikasi</button>
            </div>
        </form>
    </div>
</div>
@endsection