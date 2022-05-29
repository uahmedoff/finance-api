<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'name' => 'required|string',
            'icon' => 'required|string',
            'color' => 'nullable|string',
            'bgcolor' => 'nullable|string',
            'type' => 'required|integer|in:1,2',
            'parent_id' => 'nullable|uuid',
            'wallet_id' => 'required|uuid'
        ];
    }
}
