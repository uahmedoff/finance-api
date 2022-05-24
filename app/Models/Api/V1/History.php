<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Chelout\RelationshipEvents\Concerns\HasMorphToEvents;

class History extends Model{
    
    use HasFactory, HasUuid, HasMorphToEvents;

    const UPDATED_AT = null; 

    const STATUS_MODEL_CREATED = 1;
    const STATUS_MODEL_UPDATED = 2;
    const STATUS_MODEL_DELETED = 3;
    const STATUS_ROLE_ATTACHED = 4;
    const STATUS_ROLE_DETACHED = 5;

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
