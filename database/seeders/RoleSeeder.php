<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'country_financial_manager', 'guard_name' => 'admin-api']);
        Role::create(['name' => 'office_manager', 'guard_name' => 'admin-api']);
        Role::create(['name' => 'office_financial_manager', 'guard_name' => 'admin-api']);
        Role::create(['name' => 'employee', 'guard_name' => 'admin-api']);
        Role::create(['name' => 'user', 'guard_name' => 'api']);
    }
}
