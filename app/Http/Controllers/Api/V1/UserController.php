<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Role;
use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Resources\Api\V1\UserResource;

class UserController extends Controller{

    protected $user;

    public function __construct(User $user){
        $this->user = $user;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See users'))
            return response()->json(['message'=>__('auth.forbidden')],403);

        $users = $this->user;
        $users = $users->search();
        $users = $users->filter();
        $users = $users->sort()->paginate($this->per_page);
        return UserResource::collection($users);    
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
        }        

        return new UserResource($user);    
    }

    public function show(User $user){
        if(!auth()->user()->can('See user'))
            return response()->json(['message'=>__('auth.forbidden')],403);
        
        return new UserResource($user->with('roles')->first());
    }

    public function update(UserRequest $request, User $user){
        if(!auth()->user()->can('Edit user'))
            return response()->json(['message'=>__('auth.forbidden')],403);
            
        DB::beginTransaction();
        try {
            if($request->filled('name'))
                $user->name = $request->name;
            if($request->filled('phone') && $request->phone != $user->phone)
                $user->phone = $request->phone;
            if($request->filled('password'))
                $user->password = bcrypt($request->password);
            if($request->filled('lang'))
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

    public function destroy(User $user){
        if(!auth()->user()->can('Delete user'))
            return response()->json(['message'=>__('auth.forbidden')],403);

        $user->delete();    
    }
}
