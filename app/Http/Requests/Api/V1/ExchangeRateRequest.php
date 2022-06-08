<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRateRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'currency_id' => 'required|uuid',
            'date' => 'nullable|date_format:Y-m-d',
            'rate' => 'required|numeric'
        ];
    }

}
