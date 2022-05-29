<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\Wallet;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\WalletResource;
use App\Http\Requests\Api\V1\AttachUsersToWalletRequest;

class WalletController extends Controller{
    
    public function attach_users(AttachUsersToWalletRequest $request, Wallet $wallet){
        if(!auth()->user()->can('Attach users to wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $user_ids = explode(",",$request->user_ids);
        $wallet->users()->attach($user_ids,[
            'created_at' => now(),
            'created_by' => auth()->user()->id
        ]);
        return new WalletResource($wallet);
    }

    public function detach_user(Wallet $wallet, $user_id){
        if(!auth()->user()->can('Detach user from wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallet->users()->detach($user_id);
        return new WalletResource($wallet);
    }
    
}
