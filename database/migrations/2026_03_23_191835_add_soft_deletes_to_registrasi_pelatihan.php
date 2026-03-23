<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up() {
    Schema::table('registrasi_pelatihan', function (Blueprint $table) {
        $table->softDeletes(); // Ini akan otomatis membuat kolom deleted_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrasi_pelatihan', function (Blueprint $table) {
            //
        });
    }
};
