<?php

namespace Database\Seeders;

use App\Models\Sgk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SgkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SGK::factory([
            'name'              => 'SGK Md. – WWF İZMİR',
            'address'           => '2483. Cad. No: 6',
            'city'              => 'İzmir',
        ])->create();

        SGK::factory([
            'name'              => 'SGK Md. - METROPOL ATAŞEHİR',
            'address'           => '2483. Cad. No: 6 Ataşehir',
            'city'              => 'İstanbul',
        ])->create();

        SGK::factory([
            'name'              => 'SGK Md.- ZYXEL ŞİŞLİ',
            'address'           => '2483. Cad. No: 6 Şişli',
            'city'              => 'İstanbul',
        ])->create();

    }
}
