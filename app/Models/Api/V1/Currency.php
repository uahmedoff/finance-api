<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends BaseModel{
    
    use HasFactory, 
        HasUuid, 
        ScopeTrait, 
        Userstamps, 
        SoftDeletes;

    protected $fillable = [
        'code',
        'ccy',
        'ccynm_uz',
        'ccynm_uzc',
        'ccynm_ru',
        'ccynm_en'
    ];

    private $search_columns = [
        'code',
        'ccy',
        'ccynm_uz',
        'ccynm_uzc',
        'ccynm_ru',
        'ccynm_en'
    ];

    public function scopeFilter($query){
        if ($filter = request('code')){
            $query = $query->where('code', $filter);
        }
        if ($filter = request('ccy')){
            $query = $query->where('ccy','ilike','%' .  $filter . '%');
        }
        if ($filter = request('ccynm_uz')){
            $query = $query->where('ccynm_uz','ilike','%' .  $filter . '%');
        }
        if ($filter = request('ccynm_uzc')){
            $query = $query->where('ccynm_uzc','ilike','%' .  $filter . '%');
        }
        if ($filter = request('ccynm_ru')){
            $query = $query->where('ccynm_ru','ilike','%' .  $filter . '%');
        }
        if ($filter = request('ccynm_en')){
            $query = $query->where('ccynm_en','ilike','%' .  $filter . '%');
        }
        return $query;
    }

    public function wallets(){
        return $this->hasMany(Wallet::class);
    }

    public function exchange_rates(){
        return $this->hasMany(ExchangeRate::class);
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
                    'currency' => [
                        "code" => $model->code,
                        "ccy" => $model->ccy,
                        "ccynm_uz" => $model->ccynm_uz,
                        "ccynm_uzc" => $model->ccynm_uzc,
                        "ccynm_ru" => $model->ccynm_ru,
                        "ccynm_en" => $model->ccynm_en,
                    ],
                    'created_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : []
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => User::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_CREATED_BY_USER,
                    'details' => [
                        'model' => 'currency',
                        'created' => [
                            "id" => $model->id,
                            "code" => $model->code,
                            "ccy" => $model->ccy,
                            "ccynm_uz" => $model->ccynm_uz,
                            "ccynm_uzc" => $model->ccynm_uzc,
                            "ccynm_ru" => $model->ccynm_ru,
                            "ccynm_en" => $model->ccynm_en,
                        ]
                    ]
                ]);
        });
        static::updating(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_UPDATED,
                'details' => [
                    'old_data' => [
                        "code" => $model->getOriginal('code'),
                        "ccy" => $model->getOriginal('ccy'),
                        "ccynm_uz" => $model->getOriginal('ccynm_uz'),
                        "ccynm_uzc" => $model->getOriginal('ccynm_uzc'),
                        "ccynm_ru" => $model->getOriginal('ccynm_ru'),
                        "ccynm_en" => $model->getOriginal('ccynm_en'),
                    ],
                    'new_data' => [
                        "code" => request('code'),
                        "ccy" => request('ccy'),
                        "ccynm_uz" => request('ccynm_uz'),
                        "ccynm_uzc" => request('ccynm_uzc'),
                        "ccynm_ru" => request('ccynm_ru'),
                        "ccynm_en" => request('ccynm_en'),
                    ],
                    'updated_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : []
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => User::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_UPDATED_BY_USER,
                    'details' => [
                        'model' => 'currency',
                        'updated' => [
                            "id" => $model->id,
                            'old_data' => [
                                "code" => $model->getOriginal('code'),
                                "ccy" => $model->getOriginal('ccy'),
                                "ccynm_uz" => $model->getOriginal('ccynm_uz'),
                                "ccynm_uzc" => $model->getOriginal('ccynm_uzc'),
                                "ccynm_ru" => $model->getOriginal('ccynm_ru'),
                                "ccynm_en" => $model->getOriginal('ccynm_en'),
                            ],
                            'new_data' => [
                                "code" => request('code'),
                                "ccy" => request('ccy'),
                                "ccynm_uz" => request('ccynm_uz'),
                                "ccynm_uzc" => request('ccynm_uzc'),
                                "ccynm_ru" => request('ccynm_ru'),
                                "ccynm_en" => request('ccynm_en'),
                            ],
                        ]
                    ]
                ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'currency' => [
                        "code" => $model->code,
                        "ccy" => $model->ccy,
                        "ccynm_uz" => $model->ccynm_uz,
                        "ccynm_uzc" => $model->ccynm_uzc,
                        "ccynm_ru" => $model->ccynm_ru,
                        "ccynm_en" => $model->ccynm_en,
                    ],
                    'deleted_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : []
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => User::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_DELETED_BY_USER,
                    'details' => [
                        'model' => 'currency',
                        'deleted' => [
                            'id' => $model->id,
                            "code" => $model->code,
                            "ccy" => $model->ccy,
                            "ccynm_uz" => $model->ccynm_uz,
                            "ccynm_uzc" => $model->ccynm_uzc,
                            "ccynm_ru" => $model->ccynm_ru,
                            "ccynm_en" => $model->ccynm_en,
                        ]
                    ]
                ]);
        });
    }
    
}
