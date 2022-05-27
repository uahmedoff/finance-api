<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            "code" => "required|integer",
            "ccy" => "required|string",
            "ccynm_uz" => "required|string",
            "ccynm_uzc" => "required|string",
            "ccynm_ru" => "required|string",
            "ccynm_en" => "required|string",
        ];
    }
}
