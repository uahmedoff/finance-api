<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Resources\Api\V1\UserMiniResource;
use App\Http\Resources\Api\V1\UserLoginResource;

class AuthController extends Controller{
    
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(AuthRequest $request){
        $credentials = request(['phone', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['errors' => ['phone' => [__('auth.failed')]]], 401);
        }
        return (new UserLoginResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
        return $this->respondWithToken($token);
    }

    public function me(){
        return new UserLoginResource(auth()->user());
    }

    public function logout(){
        auth()->logout();
        return response()->json(['message' => __('auth.logged_out')]);
    }

    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
