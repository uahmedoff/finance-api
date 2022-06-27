<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WalletRequest;
use App\Http\Resources\Api\V1\WalletResource;
use App\Http\Resources\Api\V1\WalletMiniResource;

class WalletResourceController extends Controller{

    protected $wallet;

    public function __construct(Wallet $wallet){
        $this->wallet = $wallet;
        parent::__construct();
    }

    public function index(Request $request){
        if(!auth()->user()->can('See wallets')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $wallets = $this->wallet
            ->search()
            ->filter()
            ->onlyMy()
            ->with(['currency','firm','users'])
            ->sort();
        if($request->filled('all') && $request->all == true)    
            $wallets = $wallets->get();
        else    
            $wallets = $wallets->paginate($this->per_page);
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
            foreach($request->categories as $category){
                $wallet->categories()->create([
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                    'color' => $category['color'],
                    'bgcolor' => $category['bgcolor'],
                    'type' => $category['type'],
                    'parent_id' => $category['parent_id'] ?? null,
                ]);
            }
            $users = [auth()->user()->id];
            if($request->users && $request->filled('users')){
                foreach($request->users as $user){
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
        $wallet = $this->wallet
            ->whereId($id)
            ->with('categories')
            ->firstOrFail();
        $balance_incomes = $wallet->income_transactions->sum('debit');
        $balance_expences = $wallet->expence_transactions->sum('credit');    
        $balance = $balance_incomes - $balance_expences;
        $wallet['balance'] = $balance;

        $cash_flow_incomes = $wallet->income_transactions->whereBetween('date',[date('Y-m-01'),date('Y-m-t 23:59')])->sum('debit');
        $cash_flow_expences = $wallet->expence_transactions->whereBetween('date',[date('Y-m-01'),date('Y-m-t 23:59')])->sum('credit');
        $monthly_cash_flow = $cash_flow_incomes - $cash_flow_expences;
        $wallet['monthly_cash_flow'] = $monthly_cash_flow;
        return new WalletResource($wallet);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $wallet = $this->wallet->findOrFail($id);
        DB::beginTransaction();
        try {
            if(
                $request->filled('name') && 
                $request->name != $wallet->getOriginal('name')
            )
                $wallet->name = $request->name;
            if(
                $request->filled('project_api_url') && 
                $request->project_api_url != $wallet->getOriginal('project_api_url')
            )
                $wallet->project_api_url = $request->project_api_url;
            if(
                $request->filled('currency_id') && 
                $request->currency_id != $wallet->getOriginal('currency_id')
            )
                $wallet->currency_id = $request->currency_id;
            if(
                $request->filled('parent_id') && 
                $request->parent_id != $wallet->getOriginal('parent_id')
            )
                $wallet->parent_id = $request->parent_id;
            if(
                $request->filled('firm_id') && 
                $request->firm_id != $wallet->getOriginal('firm_id')
            ) 
                $wallet->firm_id = $request->firm_id;               
            $wallet->save();
            foreach($request->categories as $category){
                $wallet->categories()->firstOrCreate(
                    [
                        'name' => $category['name'],
                        'icon' => $category['icon'],
                        'color' => $category['color'],
                        'bgcolor' => $category['bgcolor'],
                        'type' => $category['type'],
                        'parent_id' => $category['parent_id'] ?? null,
                    ]
                );
            }
            $users = [auth()->user()->id];
            if($request->users && $request->filled('users')){
                foreach($request->users as $user){
                    $users[] = $user;
                }
            }
            $wallet->users()->sync($users,[
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

    public function destroy($id){
        if(!auth()->user()->can('Delete wallet')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $wallet = $this->wallet->findOrFail($id);
        $wallet->delete();
        return response()->json([],204);
    }

}
