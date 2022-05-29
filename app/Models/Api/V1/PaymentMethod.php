<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends BaseModel{

    use HasFactory, 
        HasUuid, 
        ScopeTrait, 
        Userstamps, 
        SoftDeletes;

    protected $fillable = [
        'name'
    ];

    private $search_columns = [
        'name'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }

    public static function boot(){
        parent::boot();
        static::created(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_CREATED,
                'details' => [
                    'firm' => [
                        "name" => $model->name,
                    ],
                    'created_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : null
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => User::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_CREATED_BY_USER,
                    'details' => [
                        'model' => 'payment_method',
                        'created' => [
                            "id" => $model->id,
                            "name" => $model->name,
                        ]
                    ]
                ]);
        });
        static::updating(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_UPDATED,
                'details' => [
                    'old_data' => [
                        "name" => $model->getOriginal('name'),
                    ],
                    'new_data' => [
                        "name" => request('name'),
                    ],
                    'updated_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : null
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => User::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_UPDATED_BY_USER,
                    'details' => [
                        'model' => 'payment_method',
                        'updated' => [
                            "id" => $model->id,
                            'old_data' => [
                                "name" => $model->getOriginal('name'),
                            ],
                            'new_data' => [
                                "name" => request('name'),
                            ],
                        ]
                    ]
                ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'firm' => [
                        "name" => $model->name,
                    ],
                    'deleted_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : null
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => User::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_DELETED_BY_USER,
                    'details' => [
                        'model' => 'payment_method',
                        'deleted' => [
                            'id' => $model->id,
                            "name" => $model->name,
                        ]
                    ]
                ]);
        });
    }
}
