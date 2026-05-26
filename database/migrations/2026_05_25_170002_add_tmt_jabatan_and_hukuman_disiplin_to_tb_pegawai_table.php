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
        Schema::table('tb_pegawai', function (Blueprint $table) {
            $table->date('tmt_jabatan')->nullable()->after('id_jabatan');
            $table->boolean('hukuman_disiplin')->default(false)->after('tmt_jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_pegawai', function (Blueprint $table) {
            $table->dropColumn(['tmt_jabatan', 'hukuman_disiplin']);
        });
    }
};
