<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\ExchangeRate;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ExchangeRateResource;

class ExchangeRateController extends Controller{
    
    public function get_latest($ccy){
        if(!auth()->user()->can('See exchange rates'))
            return response()->json(['message' => __('auth.forbidden')],403);
        $exchange_rate = ExchangeRate::whereHas('currency',function($q)use($ccy){
                $q->where('ccy',$ccy);
            })
            ->firstOrFail();
        return new ExchangeRateResource($exchange_rate);
    }

}
