<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Category extends Model{
    
    use HasFactory, HasUuid, Userstamps, SoftDeletes;

    const TYPE_INCOME = 1;
    const TYPE_EXPENSE = 2;

    protected $fillable = [
        'name',
        'icon',
        'color',
        'bgcolor',
        'type',
        'parent_id',
        'wallet_id'
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function children(){
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }

}
