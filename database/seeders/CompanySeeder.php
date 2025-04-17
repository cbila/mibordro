<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory([
            'name'              => 'ALFA LAVAL',
            'address'           => 'Fatih, Yakacık Cad. No:23, 34885 Sancaktepe/İstanbul Telefon: (0216) 311 79 00',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'EMAAR',
            'address'           => 'Unalan Mahallesi, Libadiye Caddesi No: 82F Kat 1 Uskudar, 34700, Istanbul / TURKEY Email: info@emaar.com.tr',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'PRYM FASHION',
            'address'           => 'Mahmutbey, Ordu Cd. NO:42, 34490 Bağcılar/İstanbul',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'WWF',
            'address'           => 'Asmalı Mescit Mah. İstiklal Cddesi No: 136 Kat: 4 Beyoğlu, İstanbul Tel: (0212) 528 20 30',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'ZYXEL',
            'address'           => ' Piyale Paşa Bulvarı, Kaptan Paşa Mahallesi Ortadoğu Plaza, No:73, Kat:6, 34384 Şişli/İstanbul Telefon: 444 1 759y',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'ZYNET NETWORK',
            'address'           => 'Kaptan Paşa Mahallesi Piyale Paşa Bulvarı Ortadoğu Plaza No: 73 Kat: 6 Şişli 34384 Şişli/İSTANBUL',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'METROPOL MERKEZ',
            'address'           => 'ATATÜRK MAH.DEFNE SOKAK NO:10:A 3381-3 C1 BLOK DAİRE:134 ATAŞEHİR - İSTANBUL',
            'city'              => 'Ankara',
        ])->create();

        Company::factory([
            'name'              => 'GÜNPAŞ - BOYNER ALANYA',
            'address'           => 'Cumhuriyet Mah. Keykubat Blv. Alanyum AVM Dk:201 Alanya, Antalya',
            'city'              => 'Alanya',
        ])->create();
    }
}
