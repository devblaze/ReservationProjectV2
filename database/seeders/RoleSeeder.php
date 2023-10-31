<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            'admin',
            'manager',
            'user',
        ];

        foreach ($permissions as $permission) {
            Role::create(['name' => $permission]);
        }
    }
}
