<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Faker\Factory as Faker;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan format Indonesia

        // Pastikan ada data jabatan terlebih dahulu agar id_jabatan valid
        $jabatanIds = Jabatan::pluck('id')->toArray();

        if (empty($jabatanIds)) {
            $this->command->info('Silakan isi Data Jabatan terlebih dahulu!');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            Pegawai::create([
                'nip' => $faker->numerify('19##########'), // NIP format
                'nama' => $faker->name,
                'pangkat' => $faker->randomElement(['Penata', 'Pembina', 'Jaksa Pratama']),
                'golongan' => $faker->randomElement(['III/a', 'III/b', 'IV/a']),
                'id_jabatan' => $faker->randomElement($jabatanIds), // Mengambil ID dari database
            ]);
        }
    }
}