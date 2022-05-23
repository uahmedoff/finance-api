<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model{
    
    use HasFactory, HasUuid, Userstamps, SoftDeletes;

    protected $fillable = [
        'code',
        'ccy',
        'ccnm_uz',
        'ccnm_uzc',
        'ccnm_ru',
        'ccnm_en'
    ];

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function exchange_rates(){
        return $this->hasMany(ExchangeRate::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }
    
}
