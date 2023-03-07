<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // create roles and assign created permissions
        Role::create(['name' => 'user']);

        Role::create(['name' => 'moderator'])
            ->givePermissionTo(['edit events', 'delete events']);

        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('password')
        ]);
        $user->assignRole('super-admin');
    }
}
