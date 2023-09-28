<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::updateOrCreate(['name' => 'admin'], ['title' => 'Admin', 'is_deletable' => 0]);
        $user = Role::updateOrCreate(['name' => 'user'], ['title' => 'user', 'is_deletable' => 0]);

        $permissions = Permission::all();
        $admin->syncPermissions($permissions);

        $user->syncPermissions('view_users');
    }
}
