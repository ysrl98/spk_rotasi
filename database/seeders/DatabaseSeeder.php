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

        // 2. Seed Jabatan
        DB::table('tb_jabatan')->insert([
            ['nama_jabatan' => 'Staf Pidum', 'kuota_kosong' => 0, 'created_at' => $now, 'updated_at' => $now], // id: 1
            ['nama_jabatan' => 'Staf Pidsus', 'kuota_kosong' => 2, 'created_at' => $now, 'updated_at' => $now], // id: 2
            ['nama_jabatan' => 'Staf Intel', 'kuota_kosong' => 1, 'created_at' => $now, 'updated_at' => $now],  // id: 3
        ]);

        // 3. Seed Pegawai
        DB::table('tb_pegawai')->insert([
            ['nip' => '198001012005011001', 'nama' => 'Budi Santoso', 'pangkat' => 'Penata Muda', 'golongan' => 'III/a', 'id_jabatan' => 1, 'created_at' => $now, 'updated_at' => $now], // id: 1
            ['nip' => '198502022010011002', 'nama' => 'Andi Wijaya', 'pangkat' => 'Penata', 'golongan' => 'III/c', 'id_jabatan' => 2, 'created_at' => $now, 'updated_at' => $now],      // id: 2
            ['nip' => '199003032015011003', 'nama' => 'Citra Lestari', 'pangkat' => 'Pengatur', 'golongan' => 'II/c', 'id_jabatan' => 3, 'created_at' => $now, 'updated_at' => $now],     // id: 3
            ['nip' => '199504042020012004', 'nama' => 'Dina Mariana', 'pangkat' => 'Pengatur Muda', 'golongan' => 'II/a', 'id_jabatan' => 1, 'created_at' => $now, 'updated_at' => $now], // id: 4
        ]);

        // 4. Seed Kriteria (Disesuaikan dengan parser ProfileMatchingService)
        DB::table('tb_kriteria')->insert([
            ['nama_kriteria' => 'Pendidikan', 'created_at' => $now, 'updated_at' => $now], // id: 1
            ['nama_kriteria' => 'Masa Kerja', 'created_at' => $now, 'updated_at' => $now], // id: 2
            ['nama_kriteria' => 'Nilai SKP', 'created_at' => $now, 'updated_at' => $now],  // id: 3
            ['nama_kriteria' => 'Disiplin', 'created_at' => $now, 'updated_at' => $now],   // id: 4
            ['nama_kriteria' => 'Inisiatif', 'created_at' => $now, 'updated_at' => $now],  // id: 5
            ['nama_kriteria' => 'Kerjasama', 'created_at' => $now, 'updated_at' => $now],  // id: 6
        ]);

        // 5. Seed Target Profil (Hanya membuka profil untuk Staf Pidsus dan Staf Intel)
        DB::table('tb_target_profil')->insert([
            // Target Profil Staf Pidsus (ID 2)
            ['id_jabatan' => 2, 'id_kriteria' => 1, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 2, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 3, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 4, 'nilai_target' => 5, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 5, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 6, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],

            // Target Profil Staf Intel (ID 3)
            ['id_jabatan' => 3, 'id_kriteria' => 1, 'nilai_target' => 3, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 2, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 3, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 4, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 5, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 6, 'nilai_target' => 5, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 6. Seed Bobot Gap Standar SPK Profile Matching
        DB::table('tb_bobot_gap')->insert([
            ['selisih' => 0, 'bobot' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 1, 'bobot' => 4.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -1, 'bobot' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 2, 'bobot' => 3.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -2, 'bobot' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 3, 'bobot' => 2.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -3, 'bobot' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 4, 'bobot' => 1.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -4, 'bobot' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 7. Seed Data Arsip Pegawai (Penilaian Objektif)
        DB::table('tb_arsip')->insert([
            ['id_pegawai' => 1, 'nilai_pendidikan' => 3, 'nilai_masa_kerja' => 5, 'nilai_skp' => 4, 'nilai_disiplin' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 2, 'nilai_pendidikan' => 4, 'nilai_masa_kerja' => 4, 'nilai_skp' => 4, 'nilai_disiplin' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 3, 'nilai_pendidikan' => 3, 'nilai_masa_kerja' => 2, 'nilai_skp' => 3, 'nilai_disiplin' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 4, 'nilai_pendidikan' => 5, 'nilai_masa_kerja' => 1, 'nilai_skp' => 5, 'nilai_disiplin' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 8. Seed Data Observasi Pegawai (Penilaian Subjektif oleh Atasan)
        DB::table('tb_observasi')->insert([
            ['id_pegawai' => 1, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 3, 'nilai_kerjasama' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 2, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 4, 'nilai_kerjasama' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 3, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 5, 'nilai_kerjasama' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['id_pegawai' => 4, 'id_penilai' => $atasanId, 'nilai_inisiatif' => 4, 'nilai_kerjasama' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}