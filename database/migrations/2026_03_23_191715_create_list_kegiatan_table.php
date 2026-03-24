<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('list_kegiatan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kegiatan');
        $table->string('sub_pelaksana')->nullable(); // Kolom yang bikin error tadi
        $table->date('tgl_mulai')->nullable();
        $table->date('tgl_selesai')->nullable();
        $table->string('tempat_kegiatan')->nullable();
        $table->integer('kuota_peserta')->default(0);
        $table->text('deskripsi_kegiatan')->nullable();
        $table->string('status')->default('aktif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_kegiatan');
    }
};
