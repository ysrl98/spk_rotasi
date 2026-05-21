<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\Kriteria;
use App\Models\TargetProfil;
use Faker\Factory as Faker;

class TargetProfilSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all jabatans
        $jabatans = Jabatan::all();
        
        // Get all kriterias
        $kriterias = Kriteria::all();

        foreach ($jabatans as $jabatan) {
            foreach ($kriterias as $kriteria) {
                TargetProfil::create([
                    'id_jabatan' => $jabatan->id,
                    'id_kriteria' => $kriteria->id,
                    'nilai_target' => $faker->numberBetween(1, 5), // Skala 1-5 sesuai form
                    'tipe_faktor' => $faker->randomElement(['Core', 'Secondary'])
                ]);
            }
        }
    }
}
