<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Chelout\RelationshipEvents\Concerns\HasMorphToEvents;

class History extends BaseModel{
    
    use HasFactory, 
        ScopeTrait, 
        HasUuid, 
        HasMorphToEvents;

    const UPDATED_AT = null; 

    const STATUS_MODEL_CREATED = 1;
    const STATUS_MODEL_UPDATED = 2;
    const STATUS_MODEL_DELETED = 3;
    const STATUS_ROLE_ATTACHED = 4;
    const STATUS_ROLE_DETACHED = 5;
    const STATUS_CREATED_BY_USER = 6;
    const STATUS_UPDATED_BY_USER = 7;
    const STATUS_DELETED_BY_USER = 8;
    const STATUS_ROLE_ATTACHED_BY = 9;
    const STATUS_ROLE_DETACHED_BY = 10;
    const STATUS_PERMISSION_ATTACHED = 11;
    const STATUS_PERMISSION_DETACHED = 12;
    const STATUS_PERMISSION_ATTACHED_BY = 13;
    const STATUS_PERMISSION_DETACHED_BY = 14;
    const STATUS_PERMISSION_SYNCED = 15;
    const STATUS_PERMISSION_SYNCED_BY = 16;
    const STATUS_USER_ATTACHED_TO_WALLET = 17;
    const STATUS_USER_DETACHED_FROM_WALLET = 18;
    const STATUS_USER_ATTACHED_TO_WALLET_BY = 19;
    const STATUS_USER_DETACHED_FROM_WALLET_BY = 20;
    const STATUS_WALLET_ATTACHED_TO_USER = 21;
    const STATUS_WALLET_DETACHED_FROM_USER = 22;
    const STATUS_WALLET_ATTACHED_TO_USER_BY = 23;
    const STATUS_WALLET_DETACHED_FROM_USER_BY = 24;
    
    protected $table = 'history';

    public $timestamps = ["created_at"];

    protected $fillable = [
        'historiable_type',
        'historiable_id',
        'status',
        'details'
    ];

    protected $casts = [
        'details' => 'array',
    ];

    private $search_columns = [
    ];

    public function scopeFilter($query){
        if($filter = request('by')){
            $query = $query->whereIn('status',[
                self::STATUS_CREATED_BY_USER,
                self::STATUS_UPDATED_BY_USER,
                self::STATUS_DELETED_BY_USER,
                self::STATUS_ROLE_ATTACHED_BY,
                self::STATUS_ROLE_DETACHED_BY,
                self::STATUS_PERMISSION_ATTACHED_BY,
                self::STATUS_PERMISSION_DETACHED_BY,
                self::STATUS_PERMISSION_SYNCED_BY,
                self::STATUS_USER_ATTACHED_TO_WALLET_BY,
                self::STATUS_USER_DETACHED_FROM_WALLET_BY,
                self::STATUS_WALLET_ATTACHED_TO_USER_BY,
                self::STATUS_WALLET_DETACHED_FROM_USER_BY
            ]);
        }
        else{
            $query = $query->whereNotIn('status',[
                self::STATUS_CREATED_BY_USER,
                self::STATUS_UPDATED_BY_USER,
                self::STATUS_DELETED_BY_USER,
                self::STATUS_ROLE_ATTACHED_BY,
                self::STATUS_ROLE_DETACHED_BY,
                self::STATUS_PERMISSION_ATTACHED_BY,
                self::STATUS_PERMISSION_DETACHED_BY,
                self::STATUS_PERMISSION_SYNCED_BY,
                self::STATUS_USER_ATTACHED_TO_WALLET_BY,
                self::STATUS_USER_DETACHED_FROM_WALLET_BY,
                self::STATUS_WALLET_ATTACHED_TO_USER_BY,
                self::STATUS_WALLET_DETACHED_FROM_USER_BY
            ]);
        }
        if ($filter = request('type')){
            $filter = 'App\\Models\\Api\\V1\\' . $filter;
            $query = $query->where('historiable_type', $filter);
            if ($filter = request('type_id')){
                $query = $query->where('historiable_id', $filter);
            }
        }
        if ($filter = request('status')){
            $query = $query->where('status', $filter);
        }
        return $query;
    }

    public function historiable(){
        return $this->morphTo();
    }

}
