<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionMiniResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'roles' => $this->when(request('with_roles'),function(){
                return RoleMiniResource::collection($this->roles);
            })
        ];
    }
}
