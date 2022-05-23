<?php

namespace Database\Seeders;

use App\Models\Api\V1\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create([
            'name' => "See users",
        ]);
        Permission::create([
            'name' => "Create user",
        ]);
        Permission::create([
            'name' => "See user",
        ]);
        Permission::create([
            'name' => "Edit user",
        ]);
        Permission::create([
            'name' => "Delete user",
        ]);
        Permission::create([
            'name' => "Attach permissions to role",
        ]);
        Permission::create([
            'name' => "Attach role to user",
        ]);
    }
}
