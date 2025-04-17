<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Document;
use App\Models\Site;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            ['name' => 'Cenk Bila', 'email' => 'cenkbila@gmail.com'],
            ['name' => 'Çınar Cantürk', 'email' => 'cinarcanturk@gmail.com'],
            ['name' => 'Operator', 'email' => 'operator@gmail.com'],
            ['name' => 'Test', 'email' => 'test@gmail.com'],
        ];

        foreach ($users as $user) {
            User::factory([
                'name'              => $user['name'],
                'email'             => $user['email'],
                // 'email_verified_at' => now(),
                // 'company_id'        => 1,
            ])
            ->create();
        };

        $user = User::find(1)->assignRole('superadmin');
        $user = User::find(2)->assignRole('admin');
        $user = User::find(3)->assignRole('operator');
        // $user = User::find(4)->assignRole('user');

        // User::factory([
        //     'company_id'        => random_int(1, 6)
        // ])->count(50)
        // // ->has(Document::factory()->count(10))
        // ->create();
    }
}
