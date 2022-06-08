<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\HistoryResource;
use App\Models\Api\V1\History;
use Illuminate\Http\Request;

class HistoryController extends Controller{

    public function __invoke(Request $request){
        $history = History::filter()
            ->with('historiable')
            ->sort()
            ->paginate($this->per_page);
        return HistoryResource::collection($history);    
    }

}
