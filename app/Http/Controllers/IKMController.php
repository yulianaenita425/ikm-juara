<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\IKMImport;
use App\Exports\IKMExport;

class IKMController extends Controller
{
    // Method untuk Dashboard Admin (FITUR TETAP JAGA)
    public function dashboardAdmin() {
        $totalIkm = DB::table('pelaku_usaha')->count();
        $totalAdmin = DB::table('users')->count();
        $totalKegiatan = DB::table('list_kegiatan')->count();
        $totalPendaftar = DB::table('registrasi_pelatihan')->count();
        $Kelurahan = DB::table('pelaku_usaha')
                ->select('kelurahan', DB::raw('count(*) as total'))
                ->groupBy('kelurahan')
                ->get();

        // Perbaikan: variabel yang di-compact harus sesuai dengan nama variabel di atas ($totalIkm)
        return view('admin.dashboard', compact(
            'totalIkm', 'totalAdmin', 'totalKegiatan', 'totalPendaftar', 'Kelurahan'
        ));
    }

    // Method untuk Halaman Data IKM (FITUR TETAP JAGA)
    public function dataIkmAdmin() {
        $totalinvestasi = DB::table('pelaku_usaha')->sum('investasi');
        $totalTenagaKerja = DB::table('pelaku_usaha')->sum('tenaga_kerja');
        $totalSemuaData = DB::table('pelaku_usaha')->count(); 
        $totalPelakuUnik = DB::table('pelaku_usaha')->select('nib')->distinct()->count();
        $data = DB::table('pelaku_usaha')->orderBy('id', 'desc')->get();

        return view('admin.pelaku_usaha.index', compact(
            'data', 'totalinvestasi', 'totalTenagaKerja', 'totalSemuaData', 'totalPelakuUnik'
        ));
    }

    // Method Index (Tetap ada sebagai cadangan/default)
    public function index() {
        $totalIkm = DB::table('pelaku_usaha')->count();
        $latestData = DB::table('pelaku_usaha')->latest('updated_at')->first();
        $terakhirUpdate = $latestData ? $latestData->updated_at : now();
        $dataChart = [
            'Kartoharjo' => DB::table('pelaku_usaha')->where('kecamatan', 'Kartoharjo')->count(),
            'Manguharjo' => DB::table('pelaku_usaha')->where('kecamatan', 'Manguharjo')->count(),
            'Taman'      => DB::table('pelaku_usaha')->where('kecamatan', 'Taman')->count(),
        ];
        $berita = DB::table('publikasi')->latest()->take(10)->get();
      
        return view('welcome', compact('totalIkm', 'berita', 'terakhirUpdate', 'dataChart'));
    }

    // Method Halaman Statistik Admin (FITUR TETAP JAGA)
    public function halamanStatistik()
    {
        $stats = DB::table('statistik_kecamatan')->get();
        return view('admin.statistik', compact('stats'));
    }

    // Import & Export (FITUR TETAP JAGA)
    public function import(Request $request) 
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new IKMImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data Berhasil Diimport!');
    }

    public function export() 
    {
        return Excel::download(new IKMExport, 'data-ikm.xlsx');
    }

    /**
     * OPTIMASI FINAL: Method untuk mengambil data Manual 460
     * Memastikan kolom yang diambil adalah 'jumlah_ikm', bukan 'jumlah'
     */
    public function getStatistikManual() {
        // KOREKSI DISINI: Pastikan mengambil kolom 'jumlah_ikm'
        $statsData = DB::table('statistik_kecamatan')->pluck('jumlah_ikm', 'kecamatan');

        $dataChartManual = [
            'Kartoharjo' => $statsData['Kartoharjo'] ?? 0,
            'Manguharjo' => $statsData['Manguharjo'] ?? 0,
            'Taman'      => $statsData['Taman'] ?? 0,
        ];

        $totalIkmManual = array_sum($dataChartManual);
        $berita = DB::table('publikasi')->latest()->take(10)->get();
        $latestUpdate = DB::table('statistik_kecamatan')->latest('updated_at')->first();
        $terakhirUpdateManual = $latestUpdate ? $latestUpdate->updated_at : now();

        // Compact semua variabel agar tidak ada error 'Undefined Variable' di Blade
        return view('welcome', compact(
            'dataChartManual', 
            'totalIkmManual', 
            'terakhirUpdateManual', 
            'berita'
        ));
    }
public function updateStatistik(Request $request)
{
    // 1. Ambil data 'stats' dari request
    $dataStats = $request->input('stats');

    // 2. Jika data kosong, kembali dengan pesan peringatan
    if (!$dataStats) {
        return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
    }

    try {
        // 3. Loop dan Update berdasarkan ID
        foreach ($dataStats as $id => $nilai) {
            DB::table('statistik_kecamatan')
                ->where('id', $id)
                ->update([
                    'jumlah_ikm' => $nilai, // Mengisi kolom jumlah_ikm
                    'updated_at' => now()
                ]);
        }

        return redirect()->back()->with('success', 'Statistik Berhasil Diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}
}