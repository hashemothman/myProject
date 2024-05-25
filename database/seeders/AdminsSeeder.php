<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create users
        $countryFinancialManager = Admin::firstOrCreate([
                'email' => 'countryFinancialManager@gmail.com',
                'password' => Hash::make('password1'),
                'role_name' => 'country_financial_manager',
        ]);

        $officeManager = Admin::firstOrCreate([
            'email' => 'officeManager@gmail.com',
            'password' => Hash::make('password2'),
            'role_name' => 'office_manager',
        ]);

        $officeFinancialManager = Admin::firstOrCreate([
            'email' => 'officeFinancial_manager@gmail.com',
            'password' => Hash::make('password3'),
            'role_name' => 'office_financial_manager',
        ]);

        $employee = Admin::firstOrCreate([
            'email' => 'employee@gmail.com',
            'password' => Hash::make('password4'),
            'role_name' => 'employee',
        ]);

        // Assign roles to Admins
        $countryFinancialManager->assignRole('country_financial_manager');
        $officeManager->assignRole('office_manager');
        $officeFinancialManager->assignRole('office_financial_manager');
        $employee->assignRole('employee');
    }
}
