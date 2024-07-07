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
        $city1 = City::create([
            'city' => "homs"
        ]);
        $city2 = City::create([
            'city' => "hama"
        ]);
    }
}
