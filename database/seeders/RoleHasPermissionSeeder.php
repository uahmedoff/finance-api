<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    public function run(){
        $role = Role::findByName('Owner');
        $role->syncPermissions(Permission::all());
    }
}
