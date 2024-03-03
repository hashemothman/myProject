<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            foreach ($this->permissions as $permission) {
                Permission::create(['name' => $permission]);
            }

            // Create admin User and assign the role to him.
            $user = User::create([

                'mobile_number' => "098764378",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password')
            ]);

            $role = Role::create(['name' => 'Admin']);

            $permissions = Permission::pluck('id', 'id')->all();

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
    }
}
