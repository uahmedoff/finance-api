<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ExchangeRateRequest;
use App\Http\Resources\Api\V1\ExchangeRateResource;
use App\Http\Resources\Api\V1\ExchangeRateMiniResource;

class ExchangeRateResourceController extends Controller{

    protected $exchange_rate;

    public function __construct(ExchangeRate $exchange_rate){
        $this->exchange_rate = $exchange_rate;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See exchange rates'))
            return response()->json(['message' => __('auth.forbidden')],403);
        $exchange_rates = $this->exchange_rate
            ->filter()
            ->sort()
            ->paginate($this->per_page);
        return ExchangeRateMiniResource::collection($exchange_rates);
    }

    public function store(ExchangeRateRequest $request){
        if(!auth()->user()->can('Create exchange rate'))
            return response()->json(['message' => __('auth.forbidden')],403);
        $exchange_rate = $this->exchange_rate
            ->create([
                'currency_id' => $request->currency_id,
                'date' => ($request->filled('date')) ? $request->date : date("Y-m-d"),
                'rate' => $request->rate
            ]);
        return new ExchangeRateResource($exchange_rate);    
    }

    public function show($id){
        if(!auth()->user()->can('Create exchange rate'))
            return response()->json(['message' => __('auth.forbidden')],403);
        $exchange_rate = $this->exchange_rate->findOrFail($id);
        return new ExchangeRateResource($exchange_rate);
    }

    public function update(Request $request, $id){
        //
    }

    public function destroy($id){
        //
    }

}
