<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Role;
use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Resources\Api\V1\UserMiniResource;

class UserResourceController extends Controller{

    protected $user;

    public function __construct(User $user){
        $this->user = $user;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See users'))
            return response()->json(['message'=>__('auth.forbidden')],403);

        $users = $this->user
            ->search()
            ->filter()
            ->sort()
            ->paginate($this->per_page);
        return UserMiniResource::collection($users);    
    }

    public function store(UserRequest $request){
        if(!auth()->user()->can('Create user'))
            return response()->json(['message'=>__('auth.forbidden')],403);

        DB::beginTransaction();
        try {
            $user = $this->user->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
            $role = Role::findByName($request->role);
            $user->assignRole($role);
        
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }        

        return new UserResource($user);    
    }

    public function show($id){
        if(!auth()->user()->can('See user'))
            return response()->json(['message'=>__('auth.forbidden')],403);
        $user = $this->user->findOrFail($id)->load('roles');
        return new UserResource($user);
    }

    public function update(UserRequest $request, $id){
        if(!auth()->user()->can('Edit user'))
            return response()->json(['message'=>__('auth.forbidden')],403);
        
        $user = $this->user->findOrFail($id);
        DB::beginTransaction();
        try {
            if($request->filled('name') && $request->name != $user->getOriginal('name'))
                $user->name = $request->name;
            if($request->filled('phone') && $request->phone != $user->getOriginal('phone'))
                $user->phone = $request->phone;
            if($request->filled('password'))
                $user->password = bcrypt($request->password);
            if($request->filled('lang') && $request->lang != $user->getOriginal('lang'))
                $user->lang = $request->lang;
            $user->save();
            
            if($request->filled('role')){
                $role = Role::findByName($request->role);
                $user->syncRoles($role);
            }
        
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }        

        return new UserResource($user);    
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete user'))
            return response()->json(['message'=>__('auth.forbidden')],403);
        $user = $this->user->findOrFail($id);    
        $user->delete();    
        return response()->json([],204);
    }
}
