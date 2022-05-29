<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletMiniResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'project_api_url' => $this->project_api_url,
            // 'currency' => new CurrencyMiniResource($this->currency),
            // 'firm' => new FirmMiniResource($this->firm),
            // 'parent' => new self($this->parent) 
        ];
    }
}
