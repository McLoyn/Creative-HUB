<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        $villages = [
            // Kecamatan Kerek (Pusat Tenun Gedog & Batik Tulis Tuban)
            ['name' => 'Margorejo',    'kecamatan' => 'Kerek'],
            ['name' => 'Jarorejo',     'kecamatan' => 'Kerek'],
            ['name' => 'Gaji',         'kecamatan' => 'Kerek'],
            ['name' => 'Karanglo',     'kecamatan' => 'Kerek'],
            // Kecamatan Jenu
            ['name' => 'Sumurgeneng',  'kecamatan' => 'Jenu'],
            ['name' => 'Rawasan',      'kecamatan' => 'Jenu'],
            // Kecamatan Tuban (Kota)
            ['name' => 'Sidomulyo',    'kecamatan' => 'Tuban'],
            ['name' => 'Latsari',      'kecamatan' => 'Tuban'],
            // Kecamatan Palang
            ['name' => 'Palang',       'kecamatan' => 'Palang'],
            // Kecamatan Semanding
            ['name' => 'Semanding',    'kecamatan' => 'Semanding'],
        ];

        foreach ($villages as $village) {
            Village::create(array_merge($village, ['kabupaten' => 'Tuban']));
        }
    }
}
