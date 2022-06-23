<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Http\Resources\Api\V1\TransactionResource;
use App\Http\Resources\Api\V1\TransactionMiniResource;
use App\Services\Api\V1\TransactionService;
use App\Services\Api\V1\File;

class TransactionResourceController extends Controller{

    protected $transaction;
    
    public function __construct(Transaction $transaction){
        $this->transaction = $transaction;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See transactions'))
            return response()->json(['message'=>__('auth.forbidden')],403);    
        $transactions = $this->transaction
            ->filter()
            ->with(['wallet','category','payment_method'])
            ->sort()
            ->paginate($this->per_page);
        return TransactionMiniResource::collection($transactions);  
    }

    public function store(TransactionRequest $request, TransactionService $service){
        if(!auth()->user()->can('Create transaction'))
            return response()->json(['message'=>__('auth.forbidden')],403);
        $transaction = $service->run($request);        
        return new TransactionResource($transaction);  
    }

    public function show($id){
        if(!auth()->user()->can('See transaction'))
            return response()->json(['message'=>__('auth.forbidden')],403);    
        $transaction = $this->transaction->findOrFail($id);
        return new TransactionResource($transaction);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit transaction'))
            return response()->json(['message'=>__('auth.forbidden')],403); 
        $image = ($request->image) ? File::createFromBase64($request->image) : null;   
        $transaction = $this->transaction->findOrFail($id);
        if(
            $request->filled('wallet_id') && 
            $request->wallet_id != $transaction->getOriginal('wallet_id')
        )
            $transaction->wallet_id = $request->wallet_id;
        if(
            $request->filled('category_id') && 
            $request->category_id != $transaction->getOriginal('category_id')
        )
            $transaction->wallet_id = $request->wallet_id;
        if(
            $request->filled('payment_method_id') && 
            $request->payment_method_id != $transaction->getOriginal('payment_method_id')
        )
            $transaction->payment_method_id = $request->payment_method_id;
        if(
            $request->filled('date') && 
            $request->date != $transaction->getOriginal('date')
        )
            $transaction->date = $request->date;
        if(
            $request->filled('debit') && 
            $request->debit != $transaction->getOriginal('debit')
        )
            $transaction->debit = $request->debit;
        if(
            $request->filled('credit') && 
            $request->credit != $transaction->getOriginal('credit')
        )
            $transaction->credit = $request->credit;
        if(
            $request->filled('image') && 
            $request->image != $transaction->getOriginal('image')
        )
            $transaction->image = $image;
        if(
            $request->filled('note') && 
            $request->note != $transaction->getOriginal('note')
        )
            $transaction->note = $request->note;                       
        $transaction->save();
        return new TransactionResource($transaction);
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete transaction'))
            return response()->json(['message'=>__('auth.forbidden')],403);    
        $transaction = $this->transaction->findOrFail($id);
        $transaction->delete();
        return response()->json([],204);    
    }

}
