<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model{
    
    use HasFactory, HasUuid;

    const UPDATED_AT = null; 
    
    const STATUS_MODEL_CREATED = 1;
    const STATUS_MODEL_UPDATED = 2;
    const STATUS_MODEL_DELETED = 3;

    protected $table = 'history';

    public $timestamps = ["created_at"];

    protected $fillable = [
        'historiable_type',
        'historiable_id',
        'status',
        'description'
    ];

    public function historiable(){
        return $this->morphTo();
    }

}
