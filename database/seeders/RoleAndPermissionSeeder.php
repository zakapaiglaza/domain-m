<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        Permission::create(['name' => 'manage-domains']);
        Permission::create(['name' => 'view-checks']);

        $admin->givePermissionTo(['manage-domains', 'view-checks']);

        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
