<?php

namespace Database\Seeders\Api\V1;

use App\Models\Api\V1\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder{
    
    public function run(){
        User::create([
            'name' => 'Owner',
            'phone' => '901234567',
            'password' => bcrypt('1234567'),
            'lang' => 'en'
        ]);
    }
    
}
