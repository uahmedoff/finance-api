<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Wallet extends Model{
    
    use HasFactory, HasUuid, Userstamps, SoftDeletes;

    protected $fillable = [
        'name',
        'project_api_url',
        'currency_id',
        'parent_id',
        'firm_id',
    ];

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function children(){
        return $this->hasMany(self::class,'parent_id','id');
    }

    public function firm(){
        return $this->belongsTo(Firm::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }
}
