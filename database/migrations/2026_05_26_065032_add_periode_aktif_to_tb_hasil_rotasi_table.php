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
        Schema::table('tb_hasil_rotasi', function (Blueprint $table) {
            $table->string('periode_aktif')->after('id')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_hasil_rotasi', function (Blueprint $table) {
            $table->dropColumn('periode_aktif');
        });
    }
};
