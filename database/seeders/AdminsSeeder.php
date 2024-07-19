<?php

namespace Database\Seeders;

use App\Http\Traits\GenerateAccount;
use App\Http\Traits\WalletAndAccountTrait;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsSeeder extends Seeder
{
    use WalletAndAccountTrait, GenerateAccount;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users
        $countryFinancialManager = Admin::firstOrCreate([
            'email'          => 'countryFinancialManager@gmail.com',
            'password'       => 'password1',
            'role_name'      => 'country_financial_manager',
            'account_number' => $this->generateAdminAccountNumber()
        ]);

        $officeManager = Admin::firstOrCreate([
            'email'          => 'officeManager@gmail.com',
            'password'       => 'password2',
            'role_name'      => 'office_manager',
            'account_number' => $this->generateAdminAccountNumber()
        ]);

        $officeFinancialManager = Admin::firstOrCreate([
            'email'          => 'officeFinancial_manager@gmail.com',
            'password'       => 'password3',
            'role_name'      => 'office_financial_manager',
            'account_number' => $this->generateAdminAccountNumber()
        ]);

        $employee = Admin::firstOrCreate([
            'email'          => 'employee@gmail.com',
            'password'       => 'password4',
            'role_name'      => 'employee',
            'account_number' => $this->generateAdminAccountNumber()
        ]);

        // Create Dollar Wallets to Admins
        $this->createAdminWallet($countryFinancialManager->id, 1);
        $this->createAdminWallet($officeManager->id, 1);
        $this->createAdminWallet($officeFinancialManager->id, 1);
        $this->createAdminWallet($employee->id, 1);

        // Create Syrian Pound Wallets to Admins
        $this->createAdminWallet($countryFinancialManager->id, 2);
        $this->createAdminWallet($officeManager->id, 2);
        $this->createAdminWallet($officeFinancialManager->id, 2);
        $this->createAdminWallet($employee->id, 2);

        // Assign roles to Admins
        $countryFinancialManager->assignRole('country_financial_manager');
        $officeManager->assignRole('office_manager');
        $officeFinancialManager->assignRole('office_financial_manager');
        $employee->assignRole('employee');
    }
}
