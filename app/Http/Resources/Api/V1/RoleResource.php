<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource{

    public function toArray($request){
        return [
            // 'id' => $this->id,
            'role' => $this->name,
            'permissions' => PermissionForAuthResource::collection($this->permissions)
        ];
    }
}
