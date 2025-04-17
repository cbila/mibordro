<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view-role']);
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'update-role']);
        Permission::create(['name' => 'delete-role']);

        Permission::create(['name' => 'view-permission']);
        Permission::create(['name' => 'create-permission']);
        Permission::create(['name' => 'update-permission']);
        Permission::create(['name' => 'delete-permission']);
        
        Permission::create(['name' => 'view-company']);
        Permission::create(['name' => 'create-company']);
        Permission::create(['name' => 'update-company']);
        Permission::create(['name' => 'delete-company']);

        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);

        Permission::create(['name' => 'view-document']);
        Permission::create(['name' => 'create-document']);
        Permission::create(['name' => 'update-document']);
        Permission::create(['name' => 'delete-document']);

        // create permissions
        // $view_docs = Permission::create(['name' => 'view-document']);
        // $update_docs = Permission::create(['name' => 'update-document']);
        // $delete_docs = Permission::create(['name' => 'delete-document']);
        // $view_users = Permission::create(['name' => 'view-user']);
        // $update_users = Permission::create(['name' => 'create-user']);
        // $update_users = Permission::create(['name' => 'update-user']);
        // $delete_users = Permission::create(['name' => 'delete-user']);

        // $superadmin_role = Role::create(['name' => 'superadmin']);
        // $admin_role = Role::create(['name' => 'admin']);
        // $editor_role = Role::create(['name' => 'editor']);
        // $viewer_role = Role::create(['name' => 'viewer']);

        // $superadmin_role->givePermissionTo(Permission::all());
        // $admin_role->givePermissionTo(Permission::all());
        // $editor_role->givePermissionTo($view_docs, $update_docs, $delete_docs, $view_users);
        // $viewer_role->givePermissionTo($view_docs);
    }
}
