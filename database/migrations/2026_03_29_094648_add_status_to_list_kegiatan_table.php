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
        Schema::table('list_kegiatan', function (Blueprint $table) {
            // Menambahkan kolom is_active dengan nilai default true (1)
            $table->boolean('is_active')->default(true)->after('deskripsi_kegiatan'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('list_kegiatan', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('is_active');
        });
    }
};