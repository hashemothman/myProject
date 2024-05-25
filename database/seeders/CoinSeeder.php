<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coins = [
            ['coin_name' => 'Dollar', 'country_flag' => 'photos/coins/dollar.png'],
            ['coin_name' => 'Syrian Pound', 'country_flag' => 'photos/coins/syria.png'],
        ];

        foreach ($coins as $coin) {
            Coin::create($coin);
        }
    }
}