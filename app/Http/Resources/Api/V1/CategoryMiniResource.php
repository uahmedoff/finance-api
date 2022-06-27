<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryMiniResource extends JsonResource{

    public function toArray($request){
        return [
            'id' => $this->id,
            'wallet' => new WalletMicroResource($this->wallet),
            'name' => $this->name,
            'icon' => $this->icon,
            'color' => $this->color,
            'bgcolor' => $this->bgcolor,
            'type' => $this->type,
            // 'parent' => new CategoryMiniResource($this->parent),
        ];
    }
}
