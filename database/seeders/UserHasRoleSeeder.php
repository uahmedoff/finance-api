<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    public function run(){
        $user = User::first();
        $role = Role::findByName("Owner");
        $user->assignRole($role);
    }
}
