<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapels = [
            "Sejarah Indonesia",
            "Tauhid",
            "Akhlak",
            "Matematika",
            "Bahasa Inggris",
            "Fiqih",
            "Tafsir",
            "Al Quran Hadits",
            "Fiqh",
            "Al Quran",
            "Ilmu Tafsir",
            "Ilmu Hadits",
            "Tarikh",
            "Bahasa Arab",
            "Tafsir",
            "PPKN",
            "Ushul Fiqh",
            "B Indonesia",
            "PJOK",
            "Nahwu",
            "Sharaf",
            "Pramuka",
            "Kimia",
            "Fisika",
            "Biologi",
            "Alquran Hadits",
            "TIK",
            "Tadrib",
            "IPA",
            "IPS",
            "PAI",
            "Aqidah",
            "Tajwid",
            "Sirah",
        ];
        foreach ($mapels as $mapel) {
            Mapel::create([
                'mata_pelajaran' => $mapel,
            ]);
        }
    }
}
