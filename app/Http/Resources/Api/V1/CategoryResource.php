<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'wallet' => new WalletMiniResource($this->wallet),
            'name' => $this->name,
            'icon' => $this->icon,
            'color' => $this->color,
            'bgcolor' => $this->bgcolor,
            'type' => $this->type,
            'parent' => new CategoryMiniResource($this->parent),
            'children' => CategoryMiniResource::collection($this->children),
            'created_at' => $this->created_at,
            'created_by' => new UserMiniResource($this->creator),
            'updated_at' => $this->updated_at,
            'updated_by' => new UserMiniResource($this->editor),
            'deleted_at' => $this->deleted_at,
            'deleted_by' => new UserMiniResource($this->destroyer),
        ];
    }
}
