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
        Schema::table('tb_kriteria', function (Blueprint $table) {
            $table->string('sumber_nilai', 100)->nullable()->after('nama_kriteria')->comment('Format: arsip.nilai_pendidikan atau observasi.nilai_inisiatif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_kriteria', function (Blueprint $table) {
            $table->dropColumn('sumber_nilai');
        });
    }
};
