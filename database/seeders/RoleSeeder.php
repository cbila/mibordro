<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create([
            'name'          => 'superadmin'
        ]);
        $superadmin->givePermissionTo([
            'view-user',
            'create-user',
            'update-user',
            'delete-user',

            'view-company',
            'create-company',
            'update-company',
            'delete-company',

            'view-document',
            'create-document',
            'update-document',
            'delete-document',

            'view-role',
            'view-permission',
        ]);

        $admin = Role::create([
            'name'          => 'admin'
        ]);
        $admin->givePermissionTo([
            'view-user',
            'create-user',
            'update-user',
            'delete-user',

            'view-company',
            'create-company',
            'update-company',
            'delete-company',

            'view-document',
            'create-document',
            'update-document',
            'delete-document',

            'view-role',
            'view-permission',
        ]);

        $operator = Role::create([
            'name'          => 'operator'
        ]);
        
        $operator->givePermissionTo([
            'view-company',
            'create-company',
            'update-company',
            'view-user',
            'create-user',
            'update-user',
            'view-role',
            'view-permission',
        ]);

        $user = Role::create([
            'name'          => 'user'
        ]);
    }
}
