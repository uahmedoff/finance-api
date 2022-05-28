<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Firm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\FirmRequest;
use App\Http\Resources\Api\V1\FirmResource;
use App\Http\Resources\Api\V1\FirmMiniResource;

class FirmController extends Controller{

    protected $firm;

    public function __construct(Firm $firm){
        $this->firm = $firm;
        parent::__construct();
    }

    public function index(){
        if(!auth()->user()->can('See firms')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $firms = $this->firm
            ->search()
            ->sort()
            ->paginate($this->per_page);
        return FirmMiniResource::collection($firms);    
    }

    public function store(FirmRequest $request){
        if(!auth()->user()->can('Create firm')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $firm = $this->firm->create([
            'name' => $request->name
        ]);
        return new FirmResource($firm);
    }

    public function show($id){
        if(!auth()->user()->can('See firm')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $firm = $this->firm->findOrFail($id);
        return new FirmResource($firm);
    }

    public function update(Request $request, $id){
        if(!auth()->user()->can('Edit firm')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $firm = $this->firm->findOrFail($id);
        if($request->filled('name') && $request->name != $firm->getOriginal('name'))
            $firm->name = $request->name;
        $firm->save();    
        return new FirmResource($firm);
    }

    public function destroy($id){
        if(!auth()->user()->can('Delete firm')){
            return response()->json(['message' => __('auth.forbidden')],403);
        }

        $firm = $this->firm->findOrFail($id);
        $firm->delete();
        return response()->json([],204);
    }
}
