<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource{
    
    public function toArray($request){
        return [
            'id' => $this->id,
            'code' => $this->code,
            'ccy' => $this->ccy,
            'ccynm_uz' => $this->ccynm_uz,
            'ccynm_uzc' => $this->ccynm_uzc,
            'ccynm_ru' => $this->ccynm_ru,
            'ccynm_en' => $this->ccynm_en,
            'created_at' => $this->created_at,
            'created_by' => new UserMiniResource($this->creator),
            'updated_at' => $this->updated_at,
            'updated_by' => new UserMiniResource($this->editor),
            'deleted_at' => $this->deleted_at,
            'deleted_by' => new UserMiniResource($this->destroyer),
        ];
    }

}
