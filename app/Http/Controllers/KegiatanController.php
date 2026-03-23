<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = DB::table('list_kegiatan')->orderBy('created_at', 'desc')->get();
        return view('admin.kegiatan', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $data = [
            'nama_kegiatan' => $request->nama_kegiatan,
            'sub_pelaksana' => $request->sub_pelaksana,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'tempat_kegiatan' => $request->tempat_kegiatan,
            'kuota_peserta' => $request->kuota_peserta,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'status' => 'aktif',
        ];

        if ($request->id) {
            // Update jika ID ada
            DB::table('list_kegiatan')->where('id', $request->id)->update($data);
            return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui!');
        } else {
            // Simpan baru
            DB::table('list_kegiatan')->insert($data);
            return redirect()->back()->with('success', 'Kegiatan baru berhasil ditambahkan!');
        }
    }

    public function destroy($id)
    {
        DB::table('list_kegiatan')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}