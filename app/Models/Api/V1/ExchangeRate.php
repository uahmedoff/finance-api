<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class ExchangeRate extends BaseModel{

    use HasFactory, 
        HasUuid, 
        Userstamps;

    protected $fillable = [
        'currency_id',
        'date',
        'rate'
    ];

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }
    
}
