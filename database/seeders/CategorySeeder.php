<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory([
            'name'              => 'Bordro',
        ])->create();

        Category::factory([
            'name'              => 'İzin Formu',
        ])->create();

        Category::factory([
            'name'              => 'Özlük Dosyaları',
        ])->create();
    }
}
