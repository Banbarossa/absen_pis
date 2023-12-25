<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Khairuddin',
                'email' => 'banbarossa@gmail.com',
                'password_absen' => 'banbaros',
                'status' => 1,
                'password' => Hash::make('laravel'),
            ],
            [
                'name' => 'Rahmad Maulidan',
                'email' => 'rahmad@gmail.com',
                'password_absen' => 'rahmad',
                'status' => 1,
                'password' => Hash::make('laravel'),
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
