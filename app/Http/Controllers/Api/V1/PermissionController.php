<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Role;
use Illuminate\Http\Request;
use App\Models\Api\V1\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AttachPermissionRequest;
use App\Http\Resources\Api\V1\RoleResource;
use App\Http\Resources\Api\V1\RoleMiniResource;
use App\Http\Resources\Api\V1\PermissionMiniResource;

class PermissionController extends Controller{

    protected $role, $permission;

    public function __construct(Role $role, Permission $permission){
        $this->role = $role;
        $this->permission = $permission;
        parent::__construct();
    }
    
    public function roles(){
        if(!auth()->user()->can('See roles'))
            return response()->json(['message'=>__('auth.forbidden')],403);    

        $roles = $this->role
            ->search()
            ->withPermissionsIfRequested()
            ->sort()
            ->paginate($this->per_page);
        return RoleMiniResource::collection($roles);    
    }

    public function role($id){
        if(!auth()->user()->can('See roles'))
            return response()->json(['message'=>__('auth.forbidden')],403);    

        $role = $this->role->findOrFail($id);
        return new RoleResource($role);    
    }

    public function permissions($role_id = null){
        if(!auth()->user()->can('See permissions'))
            return response()->json(['message'=>__('auth.forbidden')],403);    

        $permissions = $this->permission
            ->search()
            ->filterRole($role_id)
            ->withRolesIfRequested()
            ->sort()
            ->paginate($this->per_page);
        return PermissionMiniResource::collection($permissions);    
    }

    public function permission($id){
        if(!auth()->user()->can('See permissions'))
            return response()->json(['message'=>__('auth.forbidden')],403);    

        $permission = $this->permission->findOrFail($id);
        return new PermissionMiniResource($permission);    
    }

    public function attach_permissions_to_role(AttachPermissionRequest $request, $role_id){
        if(!auth()->user()->can('Attach permissions to role'))
            return response()->json(['message'=>__('auth.forbidden')],403);
            
        $role = $this->role->findOrFail($role_id);
        $permissions = explode(",",$request->permissions);
        $role->syncPermissions($permissions);
        return new RoleResource($role);    
    }
}
