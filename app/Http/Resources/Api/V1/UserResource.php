<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'lang' => $this->lang,
            'created_at' => $this->created_at,
            'created_by' => new UserMiniResource($this->creator),
            'updated_at' => $this->updated_at,
            'updated_by' => new UserMiniResource($this->editor),
            'deleted_at' => $this->deleted_at,
            'deleted_by' => new UserMiniResource($this->destroyer),
            'role' => new RoleResource($this->roles[0]),
            // 'permissions' => PermissionMiniResource::collection($this->roles[0]->permissions)
        ];
    }
}
