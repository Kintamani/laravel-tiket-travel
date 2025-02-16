<?php

namespace Database\Seeders;

use App\Models\Locations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Depok', 'Tangerang', 'Bekasi',
            'Yogyakarta', 'Malang', 'Bogor', 'Pekanbaru', 'Denpasar', 'Samarinda', 'Padang', 'Pontianak', 'Banjarmasin', 'Manado'
        ];

        foreach ($cities as $city) {
            Locations::create([
                'name' => $city,
            ]);
        }
    }
}
