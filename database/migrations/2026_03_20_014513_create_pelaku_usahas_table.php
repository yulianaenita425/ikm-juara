<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaku_usahas', function (Blueprint $table) {
            $table->id();
            $table->string('nib', 13)->unique();
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
            $table->decimal('investasi', 15, 2);
            $table->integer('tenaga_kerja');
            $table->string('no_telp');
            $table->string('email');
            $table->date('tgl_terbit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaku_usahas');
    }
};