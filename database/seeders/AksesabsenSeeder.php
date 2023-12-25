<?php

namespace Database\Seeders;

use App\Models\Aksesabsen;
use Illuminate\Database\Seeder;

class AksesabsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // halaqah
        $musyrif = Aksesabsen::create([
            'nama_akses' => 'halaqah',
        ]);

        $userIds = [1, 2, 3, 4, 5];

        foreach ($userIds as $item) {
            $musyrif->users()->attach($item);
        }

    }
}
