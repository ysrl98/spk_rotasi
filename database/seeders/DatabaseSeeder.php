<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 0. Hapus data lama agar seeder bisa dijalankan berulang kali tanpa error duplikat
        Schema::disableForeignKeyConstraints();
        DB::table('tb_users')->truncate();
        DB::table('tb_jabatan')->truncate();
        DB::table('tb_pegawai')->truncate();
        DB::table('tb_kriteria')->truncate();
        DB::table('tb_target_profil')->truncate();
        DB::table('tb_bobot_gap')->truncate();
        DB::table('tb_arsip')->truncate();
        DB::table('tb_observasi')->truncate();
        DB::table('tb_hasil_rotasi')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Users (Roles)
        DB::table('tb_users')->insert([
            ['username' => 'admin', 'password' => Hash::make('password'), 'role' => 'Admin', 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'atasan', 'password' => Hash::make('password'), 'role' => 'Atasan', 'created_at' => $now, 'updated_at' => $now],
            ['username' => 'pimpinan', 'password' => Hash::make('password'), 'role' => 'Pimpinan', 'created_at' => $now, 'updated_at' => $now],
        ]);
        $atasanId = DB::table('tb_users')->where('role', 'Atasan')->first()->id;

        // 2. Call Kejari Banjarmasin Seeder for Master Data (Jabatan, Kriteria, Target Profil, Bobot Gap)
        $this->call([
            KejariBanjarmasinSeeder::class
        ]);

        // 3. Call Pegawai Dummy Seeder (50 pegawai beserta nilai Arsip & Observasinya)
        $this->call([
            PegawaiDummySeeder::class
        ]);
    }
}