<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class Roleseeder extends Seeder
{
    /**
     * Register the application's command-line roles.
     */
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'superAdmin']);
        // Assign all permissions to Super Admin
        $superAdmin->givePermissionTo(Permission::all());


        $Admin = Role::firstOrCreate(['name' => 'Admin']);
        $Admin->givePermissionTo([

            'viewUsers',
            'createUsers',
            'editUsers',
            'deleteUsers',

            'viewDocuments',
            'createDocuments',
            'editDocuments',
            'deleteDocuments'
        ]);

        $User = Role::firstOrCreate(['name' => 'User']);
        $User->givePermissionTo([
            'viewDocuments',
        ]);
    }
}
