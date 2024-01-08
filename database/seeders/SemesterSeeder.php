<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // [
            //     'nama' => 'Ganjil',
            //     'tahun' => '2023/2024',
            //     'status' => true,
            // ],
            [
                'nama' => 'Genap',
                'tahun' => '2023/2024',
                'status' => true,
            ],
            // [
            //     'nama' => 'Ganjil',
            //     'tahun' => '2024/2025',
            //     'status' => false,
            // ],
            // [
            //     'nama' => 'Genap',
            //     'tahun' => '2024/2025',
            //     'status' => false,
            // ],
        ];

        foreach ($data as $item) {
            Semester::create([
                'nama_semester' => $item['nama'],
                'tahun' => $item['tahun'],
                'status' => $item['status'],
            ]);
        }
    }
}
