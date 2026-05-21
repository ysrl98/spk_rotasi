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
        Schema::create('tb_target_profil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jabatan');
            $table->unsignedBigInteger('id_kriteria');
            $table->integer('nilai_target'); // Skala 1-5
            $table->enum('tipe_faktor', ['Core', 'Secondary']);
            $table->foreign('id_jabatan')->references('id')->on('tb_jabatan')->onDelete('cascade');
            $table->foreign('id_kriteria')->references('id')->on('tb_kriteria')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_profils');
    }
};
