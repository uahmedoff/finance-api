<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Api\V1\RoleSeeder;
use Database\Seeders\Api\V1\UserSeeder;
use Database\Seeders\Api\V1\CurrencySeeder;
use Database\Seeders\Api\V1\PermissionSeeder;
use Database\Seeders\Api\V1\UserHasRoleSeeder;
use Database\Seeders\Api\V1\RoleHasPermissionSeeder;
use Database\Seeders\Api\V1\PaymentMethodSeeder;

class DatabaseSeeder extends Seeder{

    public function run(){
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
        $this->call(UserHasRoleSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(PaymentMethodSeeder::class);
    }
    
}
