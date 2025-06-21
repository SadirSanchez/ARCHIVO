<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'viewRoles']);
        Permission::create(['name' => 'createRoles']);
        Permission::create(['name' => 'editRoles']);
        Permission::create(['name' => 'deleteRoles']);

        Permission::create(['name' => 'viewUsers']);
        Permission::create(['name' => 'createUsers']);
        Permission::create(['name' => 'editUsers']);
        Permission::create(['name' => 'deleteUsers']);

        Permission::create(['name' => 'viewDocuments']);
        Permission::create(['name' => 'createDocuments']);
        Permission::create(['name' => 'editDocuments']);
        Permission::create(['name' => 'deleteDocuments']);
    }
}
