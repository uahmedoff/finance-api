<?php

namespace Database\Seeders\Api\V1;

use App\Models\Api\V1\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder{
    
    public function run(){
        PaymentMethod::create([
            'name' => "Cash",
        ]);
        PaymentMethod::create([
            'name' => "UZCARD",
        ]);
        PaymentMethod::create([
            'name' => "HUMO",
        ]);
        PaymentMethod::create([
            'name' => "VISA",
        ]);
        PaymentMethod::create([
            'name' => "MasterCard",
        ]);
        PaymentMethod::create([
            'name' => "Bank account",
        ]);
    }

}
