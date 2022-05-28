<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AttachUsersToWalletRequest;
use App\Http\Requests\Api\V1\DetachUserFromWalletRequest;
use App\Http\Requests\Api\V1\WalletRequest;
use App\Http\Resources\Api\V1\WalletResource;
use App\Http\Resources\Api\V1\WalletMiniResource;

class WalletController extends Controller{

    protected $wallet;

    public function __construct(Wallet $wallet){
        $this->wallet = $wallet;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See wallets')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallets = $this->wallet
            ->search()
            ->filter()
            ->sort()
            ->paginate($this->per_page);
        return WalletMiniResource::collection($wallets);  
    }

    public function store(WalletRequest $request){
        if(!auth()->user()->can('Create wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        DB::beginTransaction();
        try {
            $wallet = $this->wallet->create([
                'name' => $request->name,
                'project_api_url' => $request->project_api_url,
                'currency_id' => $request->currency_id,
                'parent_id' => $request->parent_id,
                'firm_id' => $request->firm_id
            ]);
            $users = [auth()->user()->id];
            if($request->user_ids && $request->filled('user_ids')){
                $r_users = explode(",",$request->user_ids);
                foreach($r_users as $user){
                    $users[] = $user;
                }
            }
            $wallet->users()->attach($users,[
                'created_at' => now(),
                'created_by' => auth()->user()->id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }

        return new WalletResource($wallet);
    }

    public function show($id){
        if(!auth()->user()->can('See wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallet = $this->wallet->findOrFail($id);
        return new WalletResource($wallet);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallet = $this->wallet->findOrFail($id);
        if($request->filled('name') && $request->name != $wallet->getOriginal('name'))
            $wallet->name = $request->name;
        if($request->filled('project_api_url') && $request->project_api_url != $wallet->getOriginal('project_api_url'))
            $wallet->project_api_url = $request->project_api_url;
        if($request->filled('currency_id') && $request->currency_id != $wallet->getOriginal('currency_id'))
            $wallet->currency_id = $request->currency_id;
        if($request->filled('parent_id') && $request->parent_id != $wallet->getOriginal('parent_id'))
            $wallet->parent_id = $request->parent_id;
        if($request->filled('firm_id') && $request->firm_id != $wallet->getOriginal('firm_id')) 
            $wallet->firm_id = $request->firm_id;               
        $wallet->save();

        return new WalletResource($wallet);
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallet = $this->wallet->findOrFail($id);
        $wallet->delete();
        return response()->json([],204);
    }

    public function attach_users(AttachUsersToWalletRequest $request, $id){
        if(!auth()->user()->can('Attach users to wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallet = $this->wallet->findOrFail($id);
        $user_ids = explode(",",$request->user_ids);
        $wallet->users()->attach($user_ids,[
            'created_at' => now(),
            'created_by' => auth()->user()->id
        ]);
        return new WalletResource($wallet);
    }

    public function detach_user($wallet_id,$user_id){
        if(!auth()->user()->can('Detach user from wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $wallet = $this->wallet->findOrFail($wallet_id);
        $wallet->users()->detach($user_id);
        return new WalletResource($wallet);
    }
}
