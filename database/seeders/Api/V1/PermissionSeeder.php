<?php

namespace Database\Seeders\Api\V1;

use App\Models\Api\V1\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder{

    public function run(){
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
            'name' => "See roles",
        ]);
        Permission::create([
            'name' => "See permissions",
        ]);
        Permission::create([
            'name' => "Attach permissions to role",
        ]);
        Permission::create([
            'name' => "Attach role to user",
        ]);
        Permission::create([
            'name' => "See currencies",
        ]);
        Permission::create([
            'name' => "Create currency",
        ]);
        Permission::create([
            'name' => "See currency",
        ]);
        Permission::create([
            'name' => "Edit currency",
        ]);
        Permission::create([
            'name' => "Delete currency",
        ]);
        Permission::create([
            'name' => "See firms",
        ]);
        Permission::create([
            'name' => "Create firm",
        ]);
        Permission::create([
            'name' => "See firm",
        ]);
        Permission::create([
            'name' => "Edit firm",
        ]);
        Permission::create([
            'name' => "Delete firm",
        ]);
        Permission::create([
            'name' => "See wallets",
        ]);
        Permission::create([
            'name' => "Create wallet",
        ]);
        Permission::create([
            'name' => "See wallet",
        ]);
        Permission::create([
            'name' => "Edit wallet",
        ]);
        Permission::create([
            'name' => "Delete wallet",
        ]);
        Permission::create([
            'name' => "Attach users to wallet",
        ]);
        Permission::create([
            'name' => "Detach user from wallet",
        ]);
    }
    
}
