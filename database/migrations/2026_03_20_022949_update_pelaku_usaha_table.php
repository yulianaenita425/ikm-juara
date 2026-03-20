<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    // Kita gunakan create jika belum ada, atau table jika ingin menambah kolom
    Schema::dropIfExists('pelaku_usaha'); // Hapus yang lama agar bersih
    Schema::create('pelaku_usaha', function (Blueprint $table) {
        $table->id();
        $table->string('nib', 13);
        $table->string('nik', 16);
        $table->string('skala_usaha');
        $table->string('jenis_perusahaan');
        $table->string('nama_perusahaan');
        $table->string('nama_proyek');
        $table->string('nama_pemilik');
        $table->text('alamat_usaha');
        $table->string('kecamatan');
        $table->string('kelurahan');
        $table->char('kbli', 5);
        $table->text('uraian_kbli');
        $table->string('tingkat_risiko');
        $table->bigInteger('investasi'); // Pastikan kolom ini ada
        $table->integer('tenaga_kerja');
        $table->string('no_telp');
        $table->string('email');
        $table->date('tgl_terbit');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
