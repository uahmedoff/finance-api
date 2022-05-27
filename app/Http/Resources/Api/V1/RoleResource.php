<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource{

    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => PermissionMiniResource::collection($this->permissions)
        ];
    }
}