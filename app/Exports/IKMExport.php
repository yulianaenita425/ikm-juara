namespace App\Exports;

use App\Models\IKM;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IKMExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil data tertentu saja agar file tidak terlalu berat
        return IKM::select('nib', 'nik', 'nama_perusahaan', 'pemilik', 'investasi')->get();
    }

    public function headings(): array
    {
        return ["NIB", "NIK", "Nama Perusahaan", "Nama Pemilik", "Total Investasi"];
    }
}