<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Api\V1\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CurrencyRequest;
use App\Http\Resources\Api\V1\CurrencyResource;
use App\Http\Resources\Api\V1\CurrencyMiniResource;

class CurrencyController extends Controller{

    protected $currency;

    public function __construct(Currency $currency){
        $this->currency = $currency;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See currencies')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $currencies = $this->currency
            ->search()
            ->filter()
            ->sort()
            ->paginate($this->per_page);

        return CurrencyMiniResource::collection($currencies);
    }

    public function store(CurrencyRequest $request){
        if(!auth()->user()->can('Create currency')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $currency = $this->currency->create([
            "code" => $request->code,
            "ccy" => $request->ccy,
            "ccynm_uz" => $request->ccynm_uz,
            "ccynm_uzc" => $request->ccynm_uzc,
            "ccynm_ru" => $request->ccynm_ru,
            "ccynm_en" => $request->ccynm_en,
        ]);
        return new CurrencyResource($currency);
    }

    public function show($id){
        if(!auth()->user()->can('See currency')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $currency = $this->currency->findOrFail($id);
        return new CurrencyResource($currency);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit currency')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $currency = $this->currency->findOrFail($id);
        if($request->filled('code') && $request->code != $currency->getOriginal('code'))
            $currency->code = $request->code;
        if($request->filled('ccy') && $request->ccy != $currency->getOriginal('ccy'))
            $currency->ccy = $request->ccy;
        if($request->filled('ccynm_uz') && $request->ccynm_uz != $currency->getOriginal('ccynm_uz'))
            $currency->ccynm_uz = $request->ccynm_uz;
        if($request->filled('ccynm_uzc') && $request->ccynm_uzc != $currency->getOriginal('ccynm_uzc'))
            $currency->ccynm_uzc = $request->ccynm_uzc;
        if($request->filled('ccynm_ru') && $request->ccynm_ru != $currency->getOriginal('ccynm_ru'))
            $currency->ccynm_ru = $request->ccynm_ru;
        if($request->filled('ccynm_en') && $request->ccynm_en != $currency->getOriginal('ccynm_en'))
            $currency->ccynm_en = $request->ccynm_en;
        $currency->save();
        return new CurrencyResource($currency);
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete currency')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }
        $currency = $this->currency->findOrFail($id);
        $currency->delete();
        return response()->json([],204);
    }
}
