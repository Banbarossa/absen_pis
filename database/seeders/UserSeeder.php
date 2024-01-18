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

        // $data = [

        //     [
        //         'name' => 'Rahmad Maulidan',
        //         'email' => 'rahmad@gmail.com',
        //         'password_absen' => 'rahmad',
        //     ],
        //     [
        //         'name' => 'Jefriyandi',
        //         'email' => 'jefriyandi@gmail.com',
        //         'password_absen' => 'yandi',
        //     ],
        //     [
        //         'name' => 'Ibnu Rusdi',
        //         'email' => 'ibnu@gmail.com',
        //         'password_absen' => 'hadir123',
        //     ],
        //     [
        //         'name' => 'Banta Cut Abdurrazaq',
        //         'email' => 'banta@gmail.com',
        //         'password_absen' => 'al12052017',
        //     ],
        //     [
        //         'name' => 'Agus Suhaji',
        //         'email' => 'agus@gmail.com',
        //         'password_absen' => '250800',
        //     ],
        //     [
        //         'name' => 'Muhammad Isa',
        //         'email' => 'isa@gmail.com',
        //         'password_absen' => 'awwalul',
        //     ],
        //     [
        //         'name' => 'Ust Faisal Lifiansyah',
        //         'email' => 'ust@gmail.com',
        //         'password_absen' => 'Pis2024',
        //     ],
        //     [
        //         'name' => 'Ahmad Kamal',
        //         'email' => 'ahmad@gmail.com',
        //         'password_absen' => 'Tadrib',
        //     ],
        //     [
        //         'name' => 'Edi Bardi',
        //         'email' => 'edi@gmail.com',
        //         'password_absen' => 'lotus',
        //     ],
        //     [
        //         'name' => 'Ilham Marzuki',
        //         'email' => 'ilham@gmail.com',
        //         'password_absen' => '2023',
        //     ],
        //     [
        //         'name' => 'Maryadi',
        //         'email' => 'maryadi@gmail.com',
        //         'password_absen' => 'm4r14di',
        //     ],
        //     [
        //         'name' => 'Rifqan',
        //         'email' => 'rifqan@gmail.com',
        //         'password_absen' => 'rifqan93',
        //     ],
        //     [
        //         'name' => 'Iful Rozi',
        //         'email' => 'iful@gmail.com',
        //         'password_absen' => '16111992',
        //     ],
        //     [
        //         'name' => 'Baihaqi',
        //         'email' => 'baihaqi@gmail.com',
        //         'password_absen' => 'baihaqii',
        //     ],
        //     [
        //         'name' => 'Fajri',
        //         'email' => 'fajri@gmail.com',
        //         'password_absen' => '81988',
        //     ],
        //     [
        //         'name' => 'Zulkarnain, S.Pd',
        //         'email' => 'zulkarnain,s.pd@gmail.com',
        //         'password_absen' => '703',
        //     ],
        //     [
        //         'name' => 'Fahmirizal Fauzi',
        //         'email' => 'fahmirizal@gmail.com',
        //         'password_absen' => 'mtk_fisika',
        //     ],
        //     [
        //         'name' => 'Dedy Rizaldi',
        //         'email' => 'dedy@gmail.com',
        //         'password_absen' => 'rizaldi',
        //     ],
        //     [
        //         'name' => 'Haris Maulana',
        //         'email' => 'haris@gmail.com',
        //         'password_absen' => 'Bismillah77',
        //     ],
        //     [
        //         'name' => 'Fachrurrozi',
        //         'email' => 'fachrurrozi@gmail.com',
        //         'password_absen' => 'rozi',
        //     ],
        //     [
        //         'name' => 'Julizar S.Pd',
        //         'email' => 'julizar@gmail.com',
        //         'password_absen' => 'faza123422',
        //     ],
        //     [
        //         'name' => 'Heriandy',
        //         'email' => 'heriandy@gmail.com',
        //         'password_absen' => '150589',
        //     ],
        //     [
        //         'name' => 'Ammar',
        //         'email' => 'ammar@gmail.com',
        //         'password_absen' => '40891',
        //     ],
        //     [
        //         'name' => 'Hendri R',
        //         'email' => 'hendri@gmail.com',
        //         'password_absen' => 'Shirotora',
        //     ],
        //     [
        //         'name' => 'Samir Abdullah',
        //         'email' => 'samir@gmail.com',
        //         'password_absen' => 'islam',
        //     ],
        //     [
        //         'name' => 'safwan',
        //         'email' => 'safwan@gmail.com',
        //         'password_absen' => 'fotografi',
        //     ],
        //     [
        //         'name' => 'khairil anwar',
        //         'email' => 'khairil@gmail.com',
        //         'password_absen' => 'mama',
        //     ],
        //     [
        //         'name' => 'Rajif Fahmi',
        //         'email' => 'rajif@gmail.com',
        //         'password_absen' => 'rajif88',
        //     ],
        //     [
        //         'name' => 'Pardi',
        //         'email' => 'pardi@gmail.com',
        //         'password_absen' => 'pardi',
        //     ],
        //     [
        //         'name' => 'Fitri Muliadi',
        //         'email' => 'fitri@gmail.com',
        //         'password_absen' => 'muliadi',
        //     ],
        //     [
        //         'name' => 'Faisal Yudeska',
        //         'email' => 'faisal@gmail.com',
        //         'password_absen' => 'yudes',
        //     ],
        //     [
        //         'name' => 'Burhana Robbi',
        //         'email' => 'burhana@gmail.com',
        //         'password_absen' => 'robbi123',
        //     ],
        //     [
        //         'name' => 'Muhammad Al Kausar',
        //         'email' => 'kausar@gmail.com',
        //         'password_absen' => 'alkausar',
        //     ],
        //     [
        //         'name' => 'Irhas Auladi',
        //         'email' => 'irhas@gmail.com',
        //         'password_absen' => 'aulad!',
        //     ],
        //     [
        //         'name' => 'David',
        //         'email' => 'david@gmail.com',
        //         'password_absen' => 'daveed',
        //     ],
        // ];

        // foreach ($data as $item) {
        //     User::create([
        //         'name' => $item['name'],
        //         'email' => $item['email'],
        //         'password_absen' => $item['password_absen'],
        //         'status' => 1,
        //         'password' => Hash::make('GoAhead'),
        //     ]);
        // }

        User::create([
            'name' => 'Khairuddin',
            'email' => 'banbarossa@gmail.com',
            'password_absen' => 'banbaros',
            'status' => 1,
            'password' => Hash::make('GoInternasional'),
        ]);

    }
}
