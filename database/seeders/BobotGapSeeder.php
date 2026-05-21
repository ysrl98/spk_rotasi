<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BobotGap;

class BobotGapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Standar Bobot GAP untuk metode Profile Matching
        $data = [
            ['selisih' => 0, 'bobot' => 5],
            ['selisih' => 1, 'bobot' => 4.5],
            ['selisih' => -1, 'bobot' => 4],
            ['selisih' => 2, 'bobot' => 3.5],
            ['selisih' => -2, 'bobot' => 3],
            ['selisih' => 3, 'bobot' => 2.5],
            ['selisih' => -3, 'bobot' => 2],
            ['selisih' => 4, 'bobot' => 1.5],
            ['selisih' => -4, 'bobot' => 1],
        ];

        foreach ($data as $item) {
            BobotGap::create($item);
        }
    }
}
