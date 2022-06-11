<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'lang' => $this->lang,
            'role' => new RoleMiniResource($this->roles[0]),
            'permissions' => PermissionMiniResource::collection($this->roles[0]->permissions)
        ];
    }
}
