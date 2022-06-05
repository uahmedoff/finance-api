<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'date' => $this->date,
            'debit' => $this->debit,
            'credit' => $this->credit,
            'image' => $this->image,
            'note' => $this->note,
            'wallet' => new WalletMiniResource($this->wallet),
            'category' => new CategoryMiniResource($this->category),
            'payment_method' => new PaymentMethodMiniResource($this->payment_method),
            'created_at' => $this->created_at,
            'created_by' => new UserMiniResource($this->creator),
            'updated_at' => $this->updated_at,
            'updated_by' => new UserMiniResource($this->editor),
            'deleted_at' => $this->deleted_at,
            'deleted_by' => new UserMiniResource($this->destroyer),
        ];
    }

}
