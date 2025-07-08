<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Sadir Sánchez',
        //     'email' => 'sadir.sanchez@gmail.com',
        //     'password' => bcrypt('Sadir1478*'),
        // ])->assignRole('superAdmin');

        User::create([
            'name' => 'Sair Sánchez',
            'email' => 'sairjsanchez@gmail.com',
            'password' => bcrypt('Sair1478*'),
        ])->assignRole('superAdmin');
    }
}
