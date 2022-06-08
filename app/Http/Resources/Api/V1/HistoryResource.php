<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource{
    
    public function toArray($request){
        $type = str_replace('App\\Models\\Api\\V1\\','',$this->historiable_type);
        $historiable = null;
        switch($type){
            case "User":
                $historiable = new UserMiniResource($this->historiable);
                break;
            case "Role":
                $historiable = new RoleMiniResource($this->historiable);
                break;
            case "Permission":
                $historiable = new PermissionMiniResource($this->historiable);
                break;    
            case "Currency":
                $historiable = new CurrencyMiniResource($this->historiable);
                break;    
            case "Firm":
                $historiable = new FirmMiniResource($this->historiable);
                break;    
            case "Wallet":
                $historiable = new WalletMiniResource($this->historiable);
                break;    
            case "Category":
                $historiable = new CategoryMiniResource($this->historiable);
                break;    
            case "PaymentMethod":
                $historiable = new PaymentMethodMiniResource($this->historiable);
                break;
            case "Transaction":
                $historiable = new TransactionMiniResource($this->historiable);
                break;    
            case "ExchangeRate":
                $historiable = new ExchangeRateMiniResource($this->historiable);
                break;    
        }
        return [
            'id' => $this->id,
            'type' => $type,
            'historiable' => $historiable,
            'status' => $this->status,
            'details' => $this->details,
            'created_at' => $this->created_at      
        ];
    }

}
