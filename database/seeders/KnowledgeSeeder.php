<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KnowledgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Knowledge::factory(50)->create();
    }
}
