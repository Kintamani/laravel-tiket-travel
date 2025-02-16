<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'username' => "admin",
            ],
            [
                'name' => "Admin",
                'username' => "admin",
                'email' => "admin@mail.com",
                'password' => bcrypt('admin'),
            ]
        );

        $penumpang = User::updateOrCreate(
            [
                'username' => "penumpang",
            ],
            [
                'name' => "Penumpang",
                'username' => "penumpang",
                'email' => "penumpang@mail.com",
                'password' => bcrypt('penumpang'),
            ]
        );

        $admin->assignRole("admin");
        $penumpang->assignRole("penumpang");
    }
}
