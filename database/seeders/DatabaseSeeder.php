<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    protected $tables = [
        'companies', 'categories', 'sgks', 'permissions', 'roles', 'users', 'documents',
    ];

    protected $seeders = [
        'CompanySeeder',
        'CategorySeeder',
        'SgkSeeder',
        'PermissionsSeeder',
        'RoleSeeder',
        'UsersSeeder',
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Model::unguard();

        $this->setFKCheckOff();

        $this->cleanDatabase();

        // $this->call([
        //     UsersTableSeeder::class,
        //     PermissionsTableSeeder::class,
        // ]);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($this->seeders as $seedClass) {
            Artisan::call('db:seed', ['--class' => $seedClass]);
        }



        $this->setFKCheckOn();

        Model::reguard();

    }

    public function cleanDatabase()
    {
        $this->setFKCheckOff();

        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }



        $this->setFKCheckOn();
    }

    private function setFKCheckOff()
    {
        switch (DB::getDriverName()) {
            case 'mariadb':
                Schema::disableForeignKeyConstraints();
                break;
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = OFF');
                break;
        }
    }

    private function setFKCheckOn()
    {
        switch (DB::getDriverName()) {
            case 'mariadb':
                Schema::enableForeignKeyConstraints();
                break;
            case 'mysql':
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                break;
            case 'sqlite':
                DB::statement('PRAGMA foreign_keys = ON');
                break;
        }
    }
}
