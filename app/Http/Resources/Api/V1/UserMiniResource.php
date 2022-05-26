<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMiniResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone
        ];
    }
}
