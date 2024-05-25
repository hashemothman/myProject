<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Traits\WalletAndAccountTrait;
use Illuminate\Database\Seeder;

use Database\Seeders\CoinSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminsSeeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\AssignPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    use WalletAndAccountTrait;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        // \App\Models\Admin::create([
        //     'email' => 'yousef@gmail.com',
        //     'password' => Hash::make('12345678'),
        //     'role_name' => 'sssss',
        // ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AssignPermissionsSeeder::class,
            AdminsSeeder::class,
            CoinSeeder::class,
        ]);

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
