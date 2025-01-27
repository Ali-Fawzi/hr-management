<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supervisorUser = User::create([
            'name' => 'Super Admin',
            'email' => 'supervisor@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        $hrUser = User::create([
            'name' => 'Human Resource',
            'email' => 'hr@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $supervisorRole = Role::create(['name' => 'Supervisor']);
        $hrRole = Role::create(['name' => 'HR']);

        $permissions = Permission::pluck('id', 'name')->all();
        $excludedPermissions = [
            'employee-approve-reject',
        ];

        $supervisorRole->syncPermissions($permissions);

        $hrPermissions = array_diff_key($permissions, array_flip($excludedPermissions));

        $hrRole->syncPermissions($hrPermissions);

        $supervisorUser->assignRole([$supervisorRole->id]);
        $hrUser->assignRole([$hrRole->id]);

    }
}
