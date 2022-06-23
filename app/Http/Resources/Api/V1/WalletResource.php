<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'project_api_url' => $this->project_api_url,
            'currency' => new CurrencyMiniResource($this->currency),
            'firm' => new FirmMiniResource($this->firm),
            'parent' => new WalletMiniResource($this->parent),
            'children' => WalletMiniResource::collection($this->children),
            'created_at' => $this->created_at,
            'created_by' => new UserMiniResource($this->creator),
            'updated_at' => $this->updated_at,
            'updated_by' => new UserMiniResource($this->editor),
            'deleted_at' => $this->deleted_at,
            'deleted_by' => new UserMiniResource($this->destroyer),
            'users' => UserMiniResource::collection($this->users),
            'categories' => CategoryResource::collection($this->categories),
            'balance' => $this->balance,
            'monthly_cash_flow' => $this->monthly_cash_flow
        ];
    }
}
