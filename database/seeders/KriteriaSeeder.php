<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Kriteria;
use Faker\Factory as Faker;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $kriterias = [
            'Kemampuan Kerja (Job Match)',
            'Prestasi Kerja (Performance)',
            'Masa Kerja (Tenure)',
            'Usia (Age)',
            'Kecocokan Budaya (Culture Fit)',
            'Kesehatan (Health Status)',
            'Kualifikasi Pendidikan (Education)',
            'Kompetensi Khusus (Special Skills)'
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create([
                'nama_kriteria' => $kriteria,
            ]);
        }
    }
}