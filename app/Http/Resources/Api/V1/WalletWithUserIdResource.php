<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletWithUserIdResource extends JsonResource{
    
    public function toArray($request){
        return $this->id;
    }

}
