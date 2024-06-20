<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => "82da6c32-366b-4095-a5e5-0933b7833a0f",
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('admin'),
            'role' => Role::SUPER_ADMIN,
        ]);
        // User::create([
        //     'id' => "82da6c32-366b-3231-a5e5-8795t8944a0f",
        //     'name' => 'User 2',
        //     'username' => 'user_2',
        //     'email' => 'user@user',
        //     'password' => Hash::make('user'),
        //     'role' => Role::ADMIN,
        // ]);
    }
}
