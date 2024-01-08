<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolah = [
            // [
            //     'npsn' => 12345678,
            //     'nama' => 'Marhalah Ibtidaiyyah',
            //     'user_id' => 1,
            //     'jenjang' => 'sd',
            // ],
            [
                'npsn' => 12345679,
                'nama' => 'SMP Plus Imam Syafii',
                'user_id' => 2,
                'jenjang' => 'smp',
            ],
            [
                'npsn' => 22345679,
                'nama' => 'MAS Imam Syafii',
                'user_id' => 3,
                'jenjang' => 'sma',
            ],
        ];

        foreach ($sekolah as $item) {

            Sekolah::create([
                'npsn' => $item['npsn'],
                'nama' => $item['nama'],
                'user_id' => $item['user_id'],
                'jenjang' => $item['jenjang'],
            ]);
        }
    }
}
