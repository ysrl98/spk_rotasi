<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PegawaiDummySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $now = Carbon::now();
        
        // Ambil ID Atasan
        $atasan = DB::table('tb_users')->where('role', 'Atasan')->first();
        $atasanId = $atasan ? $atasan->id : 2;

        $pangkatGolongan = [
            ['pangkat' => 'Pengatur Muda', 'golongan' => 'II/a'],
            ['pangkat' => 'Pengatur Tingkat I', 'golongan' => 'II/d'],
            ['pangkat' => 'Penata Muda', 'golongan' => 'III/a'],
            ['pangkat' => 'Penata Muda Tingkat I', 'golongan' => 'III/b'],
            ['pangkat' => 'Penata', 'golongan' => 'III/c'],
            ['pangkat' => 'Pembina', 'golongan' => 'IV/a'],
        ];

        $pegawais = [];
        $arsips = [];
        $observasis = [];

        // Buat 50 Data Pegawai
        for ($i = 1; $i <= 50; $i++) {
            $nip = $faker->unique()->numerify('19########20######');
            $pg = $faker->randomElement($pangkatGolongan);
            
            // TMT Jabatan bervariasi: 1 tahun lalu hingga 6 tahun lalu (untuk testing eligibilitas > 2 tahun)
            $tmtDate = Carbon::now()->subMonths(rand(6, 72));
            
            // Hukuman disiplin (peluang 10% pernah dihukum)
            $isHukum = $faker->boolean(10);

            $pegawais[] = [
                // 'id' => akan auto increment tapi kita butuh tau ID nya untuk arsip. 
                // Karena DatabaseSeeder men-truncate tabel, ID akan mulai dari 1 sampai 50.
                'id' => $i,
                'nip' => $nip,
                'nama' => $faker->name,
                'pangkat' => $pg['pangkat'],
                'golongan' => $pg['golongan'],
                'id_jabatan' => $faker->numberBetween(1, 6), // 6 Jabatan dari KejariBanjarmasinSeeder
                'tmt_jabatan' => $tmtDate->format('Y-m-d'),
                'hukuman_disiplin' => $isHukum,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Nilai Arsip (Objektif) acak antara 2 hingga 5
            $arsips[] = [
                'id_pegawai' => $i,
                'nilai_pendidikan' => $faker->numberBetween(2, 5),
                'nilai_masa_kerja' => $faker->numberBetween(2, 5),
                'nilai_skp' => $faker->numberBetween(2, 5),
                'nilai_disiplin' => $isHukum ? 1 : $faker->numberBetween(3, 5), // Jika dihukum, nilainya 1
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Nilai Observasi (Subjektif) acak antara 2 hingga 5
            $observasis[] = [
                'id_pegawai' => $i,
                'id_penilai' => $atasanId,
                'nilai_inisiatif' => $faker->numberBetween(2, 5),
                'nilai_kerjasama' => $faker->numberBetween(2, 5),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert Batch
        DB::table('tb_pegawai')->insert($pegawais);
        DB::table('tb_arsip')->insert($arsips);
        DB::table('tb_observasi')->insert($observasis);
    }
}
