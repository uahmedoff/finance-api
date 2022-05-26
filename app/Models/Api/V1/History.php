<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Chelout\RelationshipEvents\Concerns\HasMorphToEvents;

class History extends BaseModel{
    
    use HasFactory, 
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

    public function historiable(){
        return $this->morphTo();
    }

}
