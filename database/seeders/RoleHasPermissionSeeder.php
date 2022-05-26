<?php

namespace Database\Seeders;

use App\Models\Api\V1\Permission;
use App\Models\Api\V1\Role;
use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder{

    public function run(){
        $role = Role::findByName('CEO');
        $role->syncPermissions(Permission::all());
    }
    
}
