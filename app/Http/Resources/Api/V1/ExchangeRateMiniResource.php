<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ExchangeRateMiniResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'date' => $this->date,
            'rate' => $this->rate,
            'currency' => new CurrencyMiniResource($this->currency),
        ];
    }

}
