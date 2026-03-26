@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<table class="w-full text-left border-collapse">
    <thead>
        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
            <th class="px-8 py-5">Nama Pengguna</th>
            <th class="px-8 py-5">Username</th>
            <th class="px-8 py-5">Password</th> <th class="px-8 py-5">Role</th> 
            <th class="px-8 py-5 text-center">Aksi</th>
        </tr>
    </thead>
<tbody class="divide-y divide-slate-50">
        @forelse($users as $user)
        <tr class="hover:bg-slate-50/50 transition">
            <td class="px-8 py-5 font-bold text-slate-700">{{ $user->name }}</td>
            <td class="px-8 py-5 text-slate-500 underline decoration-indigo-200 decoration-2 underline-offset-4">{{ $user->username }}</td>
            <td class="px-8 py-5 text-slate-400">••••••••</td> <td class="px-8 py-5">
                <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                    {{ $user->role ?? 'Admin' }}
                </span> 
            </td>
<td class="px-8 py-5 flex justify-center gap-2">
    <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->username }}')" 
            class="h-9 w-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white transition shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    </button>

    <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ $user->username }}')" 
            class="h-9 w-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
    </button>
    
    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-10 text-slate-400">Belum ada data.</td></tr>
        @endforelse
    </tbody>
</table>
<script>
function confirmDelete(id, username) {
    if (confirm("Yakin ingin menghapus akses untuk @" + username + "?")) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-indigo-900 rounded-[40px] p-8 text-white relative overflow-hidden shadow-2xl shadow-indigo-200">
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

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-[40px] p-10 shadow-2xl animate-in fade-in zoom-in duration-300">
        <h3 class="text-2xl font-black text-slate-800 mb-2 uppercase">Tambah Admin Baru</h3>
        <p class="text-slate-400 text-xs mb-8 font-medium italic">Silahkan isi kredensial untuk administrator baru.</p>
        
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Nama Lengkap" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Username</label>
                <input type="text" name="username" required placeholder="username_admin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
            </div>

            <div class="relative">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                <input type="password" name="password" id="add_password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
                <button type="button" onclick="togglePassword('add_password')" class="absolute right-5 top-11 text-slate-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            
            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeTambahModal()" class="flex-1 px-6 py-4 rounded-2xl font-bold text-slate-400 hover:bg-slate-100 transition text-sm">Batal</button>
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow-lg hover:bg-indigo-700 transition">Daftarkan Admin</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Menghilangkan notifikasi sukses secara otomatis setelah 3 detik
    setTimeout(function() {
        let alert = document.querySelector('.bg-green-50');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
<div id="modalEdit" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-[40px] p-10 shadow-2xl animate-in fade-in zoom-in duration-300">
        <h3 class="text-2xl font-black text-slate-800 mb-2 uppercase">Edit Administrator</h3>
        <p class="text-slate-400 text-xs mb-8 font-medium italic">Kosongkan password jika tidak ingin diubah.</p>
        
        <form id="formEditAdmin" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id">
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Username</label>
                <input type="text" name="username" id="edit_username" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
            </div>

            <div class="relative">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Password Baru</label>
                <input type="password" name="password" id="edit_password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:border-indigo-500 transition">
                <button type="button" onclick="togglePassword('edit_password')" class="absolute right-5 top-11 text-slate-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eye-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            
            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-6 py-4 rounded-2xl font-bold text-slate-400 hover:bg-slate-100 transition text-sm">Batal</button>
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow-lg hover:bg-indigo-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Membuka Modal Tambah
function openTambahModal() {
    document.getElementById('modalTambah').classList.remove('hidden');
}

// Menutup Modal Tambah
function closeTambahModal() {
    document.getElementById('modalTambah').classList.add('hidden');
}
    // FUNGSI TOGGLE MATA PASSWORD
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // FUNGSI MODAL EDIT
    function openEditModal(id, name, username) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_username').value = username;
        // Update Action Form secara dinamis (Pastikan route update sudah ada di web.php)
        document.getElementById('formEditAdmin').action = "/admin/pengaturan/" + id; 
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modalEdit').classList.add('hidden');
    }

    // FUNGSI HAPUS POWERFULL (SweetAlert2)
    function confirmDelete(id, username) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin mencabut akses untuk @" + username + "? Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5', // Indigo-600
            cancelButtonColor: '#ef4444', // Red-500
            confirmButtonText: 'Ya, Hapus Akses!',
            cancelButtonText: 'Batal',
            border: 'none',
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Notifikasi proses hapus
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Akses administrator telah dihapus.',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
                
                // Submit form setelah jeda sedikit agar user bisa melihat sukses
                setTimeout(() => {
                    document.getElementById('delete-form-' + id).submit();
                }, 1500);
            }
        });
    }
    @if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        timer: 3000,
        showConfirmButton: false,
        borderRadius: '20px'
    });
@endif
</script>
@endsection