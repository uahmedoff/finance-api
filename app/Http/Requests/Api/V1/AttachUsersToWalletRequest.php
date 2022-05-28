<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class AttachUsersToWalletRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'user_ids' => 'required|string'
        ];
    }
}
