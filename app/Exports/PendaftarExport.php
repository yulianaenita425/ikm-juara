<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftarExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil semua data tanpa terkecuali
        return DB::table('registrasi_pelatihan')->get();
    }

    public function headings(): array
    {
        // Sesuaikan dengan nama kolom di database Anda
        return [
            'ID', 'Nama Kegiatan', 'Nama Lengkap', 'NIK', 'NIB', 'Email', 'WhatsApp', 
            'Jenis Kelamin', 'Tanggal Lahir', 'Foto KTP', 'Nama Usaha', 'Alamat Usaha',
            'Kota', 'Kelurahan', 'Kecamatan', 'Jenis Usaha', 'Tahun Mulai', 'Skala Usaha',
            'Omzet', 'Stabilitas', 'Tantangan', 'Media', 'Karyawan Tetap', 'Karyawan Lepas',
            'Sistem Usaha', 'Level Digital', 'Pernah Pelatihan', 'Harapan', 'Target 6 Bulan',
            'Dibuat Pada', 'Diupdate Pada'
        ];
    }
}