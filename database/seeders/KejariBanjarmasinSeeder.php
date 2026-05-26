<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KejariBanjarmasinSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // 1. Data Jabatan (Bidang/Seksi di Kejari Banjarmasin)
        $jabatans = [
            ['nama_jabatan' => 'Staf Sub Bagian Pembinaan (Subagbin)', 'kuota_kosong' => 1, 'created_at' => $now, 'updated_at' => $now], // id: 1
            ['nama_jabatan' => 'Staf Seksi Intelijen', 'kuota_kosong' => 2, 'created_at' => $now, 'updated_at' => $now],                 // id: 2
            ['nama_jabatan' => 'Staf Seksi Tindak Pidana Umum (Pidum)', 'kuota_kosong' => 3, 'created_at' => $now, 'updated_at' => $now], // id: 3
            ['nama_jabatan' => 'Staf Seksi Tindak Pidana Khusus (Pidsus)', 'kuota_kosong' => 2, 'created_at' => $now, 'updated_at' => $now], // id: 4
            ['nama_jabatan' => 'Staf Seksi Perdata & Tata Usaha Negara (Datun)', 'kuota_kosong' => 1, 'created_at' => $now, 'updated_at' => $now], // id: 5
            ['nama_jabatan' => 'Staf Seksi PB3R', 'kuota_kosong' => 1, 'created_at' => $now, 'updated_at' => $now], // id: 6
        ];
        DB::table('tb_jabatan')->insert($jabatans);

        // 2. Data Kriteria
        $kriterias = [
            ['nama_kriteria' => 'Pendidikan', 'sumber_nilai' => 'arsip.nilai_pendidikan', 'created_at' => $now, 'updated_at' => $now], // id: 1
            ['nama_kriteria' => 'Masa Kerja', 'sumber_nilai' => 'arsip.nilai_masa_kerja', 'created_at' => $now, 'updated_at' => $now], // id: 2
            ['nama_kriteria' => 'Nilai SKP', 'sumber_nilai' => 'arsip.nilai_skp', 'created_at' => $now, 'updated_at' => $now],  // id: 3
            ['nama_kriteria' => 'Disiplin', 'sumber_nilai' => 'arsip.nilai_disiplin', 'created_at' => $now, 'updated_at' => $now],   // id: 4
            ['nama_kriteria' => 'Inisiatif', 'sumber_nilai' => 'observasi.nilai_inisiatif', 'created_at' => $now, 'updated_at' => $now],  // id: 5
            ['nama_kriteria' => 'Kerjasama', 'sumber_nilai' => 'observasi.nilai_kerjasama', 'created_at' => $now, 'updated_at' => $now],  // id: 6
        ];
        DB::table('tb_kriteria')->insert($kriterias);

        // 3. Matriks Target Profil (Core & Secondary) untuk tiap Jabatan
        $targetProfils = [
            // 1. Pembinaan (Fokus pada Kerjasama Tim, Loyalitas/Disiplin & Masa Kerja)
            ['id_jabatan' => 1, 'id_kriteria' => 1, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 1, 'id_kriteria' => 2, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 1, 'id_kriteria' => 3, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 1, 'id_kriteria' => 4, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 1, 'id_kriteria' => 5, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 1, 'id_kriteria' => 6, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],

            // 2. Intelijen (Fokus Lincah, Inisiatif Tinggi, Disiplin di Lapangan)
            ['id_jabatan' => 2, 'id_kriteria' => 1, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 2, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 3, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 4, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 5, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 2, 'id_kriteria' => 6, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],

            // 3. Pidum (Fokus Cekatan menangani perkara cepat, Kerjasama Eksternal Polisi/Pengadilan)
            ['id_jabatan' => 3, 'id_kriteria' => 1, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 2, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 3, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 4, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 5, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 3, 'id_kriteria' => 6, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],

            // 4. Pidsus (Fokus Penanganan Korupsi: Butuh Pendidikan/Analisa Tinggi, Kinerja Maksimal SKP)
            ['id_jabatan' => 4, 'id_kriteria' => 1, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 4, 'id_kriteria' => 2, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 4, 'id_kriteria' => 3, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 4, 'id_kriteria' => 4, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 4, 'id_kriteria' => 5, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 4, 'id_kriteria' => 6, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],

            // 5. Datun (Fokus Analisis Perdata, Bantuan Hukum Pemerintah)
            ['id_jabatan' => 5, 'id_kriteria' => 1, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 5, 'id_kriteria' => 2, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 5, 'id_kriteria' => 3, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 5, 'id_kriteria' => 4, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 5, 'id_kriteria' => 5, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 5, 'id_kriteria' => 6, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],

            // 6. PB3R (Pengelolaan Barang Bukti: Butuh Kedisiplinan Tertib Administrasi, Kejujuran/Kerjasama)
            ['id_jabatan' => 6, 'id_kriteria' => 1, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 6, 'id_kriteria' => 2, 'nilai_target' => 4, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 6, 'id_kriteria' => 3, 'nilai_target' => 4, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 6, 'id_kriteria' => 4, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 6, 'id_kriteria' => 5, 'nilai_target' => 3, 'tipe_faktor' => 'Secondary', 'created_at' => $now, 'updated_at' => $now],
            ['id_jabatan' => 6, 'id_kriteria' => 6, 'nilai_target' => 5, 'tipe_faktor' => 'Core', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('tb_target_profil')->insert($targetProfils);

        // 4. Bobot Gap Profile Matching
        $bobotGaps = [
            ['selisih' => 0, 'bobot' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 1, 'bobot' => 4.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -1, 'bobot' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 2, 'bobot' => 3.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -2, 'bobot' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 3, 'bobot' => 2.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -3, 'bobot' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => 4, 'bobot' => 1.5, 'created_at' => $now, 'updated_at' => $now],
            ['selisih' => -4, 'bobot' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('tb_bobot_gap')->insert($bobotGaps);
    }
}
