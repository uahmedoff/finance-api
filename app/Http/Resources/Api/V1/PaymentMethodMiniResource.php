<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodMiniResource extends JsonResource{

    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
