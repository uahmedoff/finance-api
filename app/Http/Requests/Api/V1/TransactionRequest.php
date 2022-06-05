<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest{
    
    const TYPE_WALLET = 1;
    const TYPE_FIRM = 2;

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'type' => 'required|integer',
            'wallet_id' => 'required_if:type,==,1|uuid',
            'firm_id' => 'required_if:type,==,2|uuid',
            'category_id' => 'required|uuid',
            'payment_method_id' => 'required|uuid',
            'date' => 'required|date_format:Y-m-d',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
            'image' => 'nullable|string',
            'note' => 'nullable|string'
        ];
    }

}
