<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    
    public function run(){
        User::create([
            'name' => 'Owner',
            'phone' => '901234567',
            'password' => bcrypt('1234567'),
            'language_id' => 1
        ]);
    }
}
