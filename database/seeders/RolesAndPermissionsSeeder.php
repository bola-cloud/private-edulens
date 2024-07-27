<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $assistant = Role::create(['name' => 'assistant']);

        // Create permissions
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'view courses']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage courses', 'view courses']);
        $assistant->givePermissionTo('view courses');
    }
}
