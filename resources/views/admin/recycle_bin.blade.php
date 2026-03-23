<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Bin - Pendaftar IKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-full mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.pendaftar') }}" class="text-blue-600 hover:underline font-bold">← Kembali</a>
                <h2 class="text-2xl font-bold text-gray-800 border-l-4 border-red-600 pl-4">Recycle Bin (Data Terhapus)</h2>
            </div>
            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">Total Sampah: {{ count($pendaftar) }}</span>
        </div>

        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-[11px] uppercase tracking-wider">
                            <th class="px-3 py-4 border-r border-gray-700">No</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">Nama Pendaftar</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">NIK</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">NIB</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">WhatsApp</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">Nama Usaha</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">Alamat Usaha</th>
                            <th class="px-3 py-4 border-r border-gray-700 text-left">Kegiatan</th>
                            <th class="px-3 py-4 text-center">Aksi Pemulihan</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-[12px] divide-y divide-gray-200">
                        @foreach($pendaftar as $index => $item)
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-3 py-4 text-center font-bold bg-gray-50 border-r">{{ $index + 1 }}</td>
                            <td class="px-3 py-4 border-r font-bold">{{ $item->nama_lengkap }}</td>
                            <td class="px-3 py-4 border-r">{{ $item->nik }}</td>
                            <td class="px-3 py-4 border-r">{{ $item->nib }}</td>
                            <td class="px-3 py-4 border-r text-blue-600 font-medium">{{ $item->whatsapp }}</td>
                            <td class="px-3 py-4 border-r font-semibold">{{ $item->nama_usaha }}</td>
                            <td class="px-3 py-4 border-r italic text-gray-600">{{ $item->alamat_usaha }}</td>
                            <td class="px-3 py-4 border-r">{{ $item->nama_kegiatan }}</td>
                            <td class="px-3 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <form action="{{ route('admin.restore', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-100 text-green-600 px-3 py-1 rounded hover:bg-green-600 hover:text-white transition font-bold whitespace-nowrap">
                                            Pulihkan
                                        </button>
                                    </form>
                                    <form id="force-delete-{{ $item->id }}" action="{{ route('admin.force_delete', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmForceDelete('{{ $item->id }}', '{{ $item->nama_lengkap }}')" class="bg-red-100 text-red-600 px-3 py-1 rounded hover:bg-red-600 hover:text-white transition font-bold whitespace-nowrap">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if(count($pendaftar) == 0)
                        <tr>
                            <td colspan="9" class="text-center py-10 text-gray-500 italic">Tidak ada data di recycle bin.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmForceDelete(id, nama) {
            Swal.fire({
                title: 'Hapus Permanen?',
                text: "Data " + nama + " akan hilang selamanya dari database!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Selamanya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('force-delete-' + id).submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({ 
                title: 'Berhasil!', 
                text: "{{ session('success') }}", 
                icon: 'success', 
                timer: 3000, 
                showConfirmButton: false 
            });
        @endif
    </script>
</body>
</html>