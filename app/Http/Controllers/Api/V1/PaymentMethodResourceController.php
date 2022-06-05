<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\V1\PaymentMethod;
use App\Http\Requests\Api\V1\PaymentMethodRequest;
use App\Http\Resources\Api\V1\PaymentMethodResource;
use App\Http\Resources\Api\V1\PaymentMethodMiniResource;

class PaymentMethodResourceController extends Controller{

    protected $payment_method;

    public function __construct(PaymentMethod $payment_method){
        $this->payment_method = $payment_method;
        parent::__construct();
    }
    
    public function index(){
        if(!auth()->user()->can('See payment methods')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $payment_methods = $this->payment_method
            ->search()
            ->sort()
            ->paginate($this->per_page);
        return PaymentMethodMiniResource::collection($payment_methods);    
    }

    public function store(PaymentMethodRequest $request){
        if(!auth()->user()->can('Create payment method')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $payment_method = $this->payment_method->create([
            'name' => $request->name
        ]);
        return new PaymentMethodResource($payment_method);
    }

    public function show($id){
        if(!auth()->user()->can('See payment method')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $payment_method = $this->payment_method->findOrFail($id);
        return new PaymentMethodResource($payment_method);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit payment method')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $payment_method = $this->payment_method->findOrFail($id);
        if(
            $request->filled('name') && 
            $request->name != $payment_method->getOriginal('name')
        )
            $payment_method->name = $request->name;
        $payment_method->save();    
        return new PaymentMethodResource($payment_method);
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete payment method')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $payment_method = $this->payment_method->findOrFail($id);
        $payment_method->delete();
        return response()->json([],204);
    }
}
