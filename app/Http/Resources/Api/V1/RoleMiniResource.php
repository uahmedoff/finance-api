<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleMiniResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => $this->when(request('with_permissions'),function(){
                return PermissionMiniResource::collection($this->permissions);
            })
        ];
    }
}
