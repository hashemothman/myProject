<?php

namespace Database\Seeders;

use App\Http\Traits\GenerateAccount;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    use GenerateAccount;
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',

        'employee-list',
        'employee-create',
        'employee-edit',
        'employee-delete',

        'coin-list',
        'coin-create',
        'coin-edit',
        'coin-delete',

        'maxAmount-list',
        'maxAmount-create',
        'maxAmount-edit',
        'maxAmount-delete',

        'wallet-list',
        'wallet-create',
        'wallet-edit',
        'wallet-delete',

        'percent-list',
        'percent-create',
        'percent-edit',
        'percent-delete',

        'office-list',
        'office-create',
        'office-edit',
        'office-delete',

        'invoice-list',
        'invoice-create',
        'invoice-edit',
        'invoice-delete',

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            foreach ($this->permissions as $permission) {
                Permission::create(['name' => $permission, 'guard_name' => 'admin-api']);
            }

            // Create admin User and assign the role to him.
            $admin = Admin::create([
                'email'          => 'admin@gmail.com',
                'password'       => 'password',
                'role_name'      => 'Manager',
                'account_number' => $this->generateAdminAccountNumber()
            ]);

            $role = Role::create(['name' => 'Manager', 'guard_name' => 'admin-api']);

            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);

            $admin->assignRole([$role->id]);
    }
}
