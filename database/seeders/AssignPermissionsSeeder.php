<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countryFinancialManager = Role::where('name', 'country_financial_manager')->where('guard_name', 'admin-api')->first();
        $officeManager = Role::where('name', 'office_manager')->first();
        $officeFinancialManager = Role::where('name', 'office_financial_manager')->first();

        $invoicePermissions = [
            'invoice-list',
            'invoice-create',
            'invoice-edit',
            'invoice-delete',
        ];

        foreach ($invoicePermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->where('guard_name', 'admin-api')->first();
            if ($permission) {
                $countryFinancialManager->givePermissionTo($permission);
            }
        }
    }
}
