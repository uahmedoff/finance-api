<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyMiniResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'code' => $this->code,
            'ccy' => $this->ccy,
            'ccynm_uz' => $this->ccynm_uz,
            'ccynm_uzc' => $this->ccynm_uzc,
            'ccynm_ru' => $this->ccynm_ru,
            'ccynm_en' => $this->ccynm_en,
        ];
    }

}
