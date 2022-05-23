<?php

namespace Database\Seeders;

use App\Models\Api\V1\Role;
use App\Models\Api\V1\User;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    public function run(){
        $user = User::first();
        $role = Role::findByName("Owner");
        $user->assignRole($role);
    }
}
