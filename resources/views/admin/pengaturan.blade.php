@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tighter uppercase">Pengaturan <span class="text-indigo-600">Akses</span></h2>
            <p class="text-slate-400 font-medium mt-1 text-sm">Kelola kredensial dan hak akses administrator sistem.</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Tambah Admin
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-600 px-6 py-4 rounded-2xl font-bold text-sm animate-bounce">
            🎉 {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-[40px] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-widest">Daftar Administrator</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] border-b border-slate-100">
                            <th class="px-8 py-6">Nama Pengguna</th>
                            <th class="px-8 py-6">Username</th>
                            <th class="px-8 py-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-semibold text-slate-600">
                        @foreach($admins as $admin)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-black">
                                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                                    </div>
                                    <span class="text-slate-800">{{ $admin->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 font-mono text-xs text-indigo-500">@ {{ $admin->username }}</td>
                            <td class="px-8 py-6 text-center">
                                @if(Auth::id() != $admin->id)
                                <form action="{{ route('admin.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Hapus admin ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                                @else
                                <span class="text-[10px] bg-slate-100 text-slate-400 px-3 py-1 rounded-full uppercase font-black tracking-tighter">Anda</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-indigo-900 rounded-[40px] p-8 text-white relative overflow-hidden card-shadow">
                <div class="relative z-10">
                    <h4 class="text-xl font-black mb-4 tracking-tight leading-tight">Keamanan Akun</h4>
                    <p class="text-indigo-200 text-xs leading-relaxed font-medium">Pastikan password menggunakan kombinasi huruf dan angka. Jangan bagikan akses login Anda kepada siapapun.</p>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-[40px] p-10 shadow-2xl animate-in fade-in zoom-in duration-300">
        <h3 class="text-2xl font-black text-slate-800 mb-2 uppercase tracking-tight">Admin Baru</h3>
        <p class="text-slate-400 text-xs mb-8 font-medium italic">Silakan lengkapi kredensial akses baru.</p>
        
        <form action="{{ route('admin.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Username</label>
                <input type="text" name="username" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition outline-none">
            </div>
            <div class="flex gap-4 pt-4">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="flex-1 px-6 py-4 rounded-2xl font-bold text-slate-400 hover:bg-slate-100 transition text-sm">Batal</button>
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection