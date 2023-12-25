<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['musyrif halaqah', 'koordinator halaqah', 'guru', 'security', 'musyrif asrama', 'admin', 'hrd', 'piket', 'pengajaran'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }

        // $guru = User::whereBetween('id', [1, 10])->get();

        // foreach ($guru as $item) {
        //     $item->assignRole('guru');
        //     $item->assignRole('musyrif halaqah');
        // }

        $admin = User::find(1)->first();
        $admin->assignRole('admin');

        // $musyrifHalaqah = User::whereBetween('id', [11, 20])->get();
        // foreach ($musyrifHalaqah as $item) {
        //     $item->assignRole('musyrif halaqah');
        // }

    }
}
