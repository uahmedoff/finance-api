<?php

namespace Database\Seeders\Api\V1;

use App\Models\Api\V1\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder{
    
    public function run(){
        
        Currency::create([
            'code'=>860,
            'ccy'=>'UZS',
            'ccynm_ru'=>'Узбекский сум',
            'ccynm_uz'=>'O`zbek so`mi',
            'ccynm_uzc'=>'Ўзбек сўми',
            'ccynm_en'=>'Uzbek Sum'
        ]);
        
        Currency::create([
            'code'=>840,
            'ccy'=>'USD',
            'ccynm_ru'=>'Доллар США',
            'ccynm_uz'=>'AQSH Dollari',
            'ccynm_uzc'=>'АҚШ доллари',
            'ccynm_en'=>'US Dollar'
        ]); 
        
    }
}
