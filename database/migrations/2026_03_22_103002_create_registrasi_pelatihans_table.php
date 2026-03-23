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
        Schema::create('registrasi_pelatihan', function (Blueprint $table) {
            $table->id();
            
            // Data Kegiatan
            $table->string('nama_kegiatan');
            
            // Data Diri
            $table->string('nama_lengkap');
            $table->string('nik', 16); // Tetap 16 digit
            $table->string('nib', 16); // Tetap 16 digit (mengakomodasi format lama/baru)
            $table->string('email');
            $table->string('whatsapp');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir')->nullable(); // Dipertahankan (nullable karena tidak ada di form depan)
            $table->string('foto_ktp'); // URL Cloudinary

            // Informasi Usaha
            $table->string('nama_usaha');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota')->default('Madiun');
            $table->string('jenis_usaha');
            $table->year('tahun_mulai');
            $table->string('skala_usaha');

            // Omzet & Tantangan
            $table->string('omzet_bulanan');
            $table->string('stabilitas_omzet');
            $table->json('tantangan_usaha')->nullable(); // Optimasi: nullable agar tidak error jika checkbox kosong
            $table->json('media_penjualan')->nullable(); // Optimasi: nullable agar tidak error jika checkbox kosong
            $table->integer('karyawan_tetap')->default(0);
            $table->integer('karyawan_tidak_tetap')->default(0);
            $table->string('sistem_usaha');

            // Insight & Digital
            $table->string('level_digital');
            $table->string('pernah_pelatihan')->nullable(); // Dipertahankan & dibuat nullable (tidak ada di form depan)
            $table->text('harapan_pelatihan')->nullable();
            $table->text('target_6_bulan')->nullable(); // Dipertahankan (nullable karena tidak ada di form depan)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN: Nama tabel harus sama dengan yang dibuat di up()
        Schema::dropIfExists('registrasi_pelatihan');
    }
};