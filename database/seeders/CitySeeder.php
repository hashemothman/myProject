<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create([
            'city' => "homs"
        ]);
        City::create([
            'city' => "hama"
        ]);
        City::create([
            'city' => "Idlib "
        ]);
        City::create([
            'city' => "Deir al-Zour"
        ]);
        City::create([
            'city' => "Al-Hasakah"
        ]);
        City::create([
            'city' => "Daraa"
        ]);
        City::create([
            'city' => "Ar-Raqqah"
        ]);
        City::create([
            'city' => "Damascus"
        ]);
        City::create([
            'city' => "Latakia"
        ]);
        City::create([
            'city' => "Tartus"
        ]);
        City::create([
            'city' => "Qamishli"
        ]);
    }
}
