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


        $permissions = Permission::pluck('id', 'id')->all();

        $supervisorRole->syncPermissions($permissions);
        $hrRole->syncPermissions($permissions);

        $supervisorUser->assignRole([$supervisorRole->id]);
        $hrUser->assignRole([$hrRole->id]);

    }
}
