<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'name' => 'required|string',
            'project_api_url' => 'nullable|string',
            'currency_id' => 'required|uuid',
            'parent_id' => 'nullable|uuid',
            'firm_id' => 'nullable|uuid',
            'user_ids' => 'nullable|string',
            'categories' => 'required|array',
            'categories.*.name' => 'required|string',
            'categories.*.icon' => 'required|string',
            'categories.*.color' => 'required|string',
            'categories.*.bgcolor' => 'required|string',
            'categories.*.type' => 'required|integer|in:1,2',
        ];
    }
}
