<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Traits\WalletAndAccountTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WalletAndAccountTrait;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        try {
            DB::beginTransaction();

            \App\Models\Admin::create([
                'email' => 'yousef@gmail.com',
                'password' => Hash::make('12345678'),
                'role_name' => 'sssss',
            ]);
            $this->createDolarAdminWallet();
            $this->createSPAdminWallet();
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }

    }
}
