<?php

namespace Database\Seeders;

use App\Models\Api\V1\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(){
        Role::create([
            'name' => "Owner",
        ]);
        Role::create([
            'name' => "Manager",
        ]);
        Role::create([
            'name' => "Cashier",
        ]);
    }
}
