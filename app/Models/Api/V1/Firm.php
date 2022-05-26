<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Firm extends BaseModel{
    
    use HasFactory, 
        HasUuid, 
        Userstamps, 
        SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }
    
}
