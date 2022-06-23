<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionMiniResource extends JsonResource{
    
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
        ];
    }

}
