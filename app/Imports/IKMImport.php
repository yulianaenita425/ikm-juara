namespace App\Imports;

use App\Models\IKM; // Pastikan nama Model sesuai
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IKMImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new IKM([
            'nib'             => $row['nib'],             // Nama kolom di Excel harus 'nib'
            'nik'             => $row['nik'],
            'skala_usaha'     => $row['skala_usaha'],
            'nama_perusahaan' => $row['nama_perusahaan'],
            'nama_proyek'     => $row['nama_proyek'],
            'pemilik'         => $row['pemilik'],
            'alamat'          => $row['alamat'],
            'kecamatan'       => $row['kecamatan'],
            'kelurahan'       => $row['kelurahan'],
            'kbli'            => $row['kbli'],
            'investasi'       => $row['investasi'],
            // Tambahkan kolom lain sesuai kebutuhan
        ]);
    }
}