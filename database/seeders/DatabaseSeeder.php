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

        // 3. Seed Pegawai (Dummy data for testing SPK)
        DB::table('tb_pegawai')->insert([
            // Budi: > 2 tahun, tidak dihukum (Eligible) - Dari Pembinaan
            ['nip' => '198001012005011001', 'nama' => 'Budi Santoso', 'pangkat' => 'Penata Muda', 'golongan' => 'III/a', 'id_jabatan' => 1, 'tmt_jabatan' => $now->copy()->subYears(3)->format('Y-m-d'), 'hukuman_disiplin' => false, 'created_at' => $now, 'updated_at' => $now], // id: 1
            // Andi: > 2 tahun, sedang dihukum (TMS) - Dari Intelijen
            ['nip' => '198502022010011002', 'nama' => 'Andi Wijaya', 'pangkat' => 'Penata', 'golongan' => 'III/c', 'id_jabatan' => 2, 'tmt_jabatan' => $now->copy()->subYears(4)->format('Y-m-d'), 'hukuman_disiplin' => true, 'created_at' => $now, 'updated_at' => $now],      // id: 2
            // Citra: < 2 tahun, tidak dihukum (TMS) - Dari Pidum
            ['nip' => '199003032015011003', 'nama' => 'Citra Lestari', 'pangkat' => 'Pengatur', 'golongan' => 'II/c', 'id_jabatan' => 3, 'tmt_jabatan' => $now->copy()->subMonths(10)->format('Y-m-d'), 'hukuman_disiplin' => false, 'created_at' => $now, 'updated_at' => $now],     // id: 3
            // Dina: > 2 tahun, tidak dihukum (Eligible) - Dari Pidsus
            ['nip' => '199504042020012004', 'nama' => 'Dina Mariana', 'pangkat' => 'Pengatur Muda', 'golongan' => 'II/a', 'id_jabatan' => 4, 'tmt_jabatan' => $now->copy()->subYears(2)->subDays(10)->format('Y-m-d'), 'hukuman_disiplin' => false, 'created_at' => $now, 'updated_at' => $now], // id: 4
        ]);

        // 4. Seed Data Arsip Pegawai (Penilaian Objektif)
        DB::table('tb_arsip')->insert([
            ['id_pegawai' => 1, 'nilai_pendidikan' => 3, 'nilai_masa_kerja' => 5, 'nilai_skp' => 4, 'nilai_disiplin' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 2, 'nilai_pendidikan' => 4, 'nilai_masa_kerja' => 4, 'nilai_skp' => 4, 'nilai_disiplin' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 3, 'nilai_pendidikan' => 3, 'nilai_masa_kerja' => 2, 'nilai_skp' => 3, 'nilai_disiplin' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 4, 'nilai_pendidikan' => 5, 'nilai_masa_kerja' => 1, 'nilai_skp' => 5, 'nilai_disiplin' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 5. Seed Data Observasi Pegawai (Penilaian Subjektif oleh Atasan)
        DB::table('tb_observasi')->insert([
            ['id_pegawai' => 1, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 3, 'nilai_kerjasama' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 2, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 4, 'nilai_kerjasama' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 3, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 5, 'nilai_kerjasama' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 4, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 4, 'nilai_kerjasama' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}