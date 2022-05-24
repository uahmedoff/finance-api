<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest{

    public function authorize(){
        return true;
    }

    public function rules(){
        if($this->method() == 'POST')
            return [
                'phone' => 'required|integer|unique:users',
                'name' => 'required',
                'password' => 'required|min:6',
                'lang' => 'nullable|max:3',
                'role' => 'required|in:CEO,CFO,Manager,Cashier'
            ];

        if($this->method() == 'PUT' || $this->method() == 'PATCH')
            return [
                'phone' => 'nullable|integer',
                'name' => 'nullable',
                'password' => 'nullable|min:6',
                'lang' => 'nullable|max:3',
                'role' => 'nullable|in:CEO,CFO,Manager,Cashier'
            ];  
    }

}
