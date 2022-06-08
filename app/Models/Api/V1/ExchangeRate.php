<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExchangeRate extends BaseModel{

    use HasFactory, 
        HasUuid, 
        ScopeTrait, 
        Userstamps;

    protected $fillable = [
        'currency_id',
        'date',
        'rate'
    ];

    private $search_columns = [
    ];

    public function scopeFilter($query){
        if ($filter = request('currency_id')){
            $query = $query->where('currency_id', $filter);
        }
        if ($filter = request('date')){
            $query = $query->where('date', $filter);
        }
        return $query;
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
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
                    'exchange_rate' => [
                        'currency' => [
                            'id' => $model->currency->id,
                            'code' => $model->currency->code,
                            'ccy' => $model->currency->ccy,
                            'ccynm_uz' => $model->currency->ccynm_uz,
                            'ccynm_uzc' => $model->currency->ccynm_uzc,
                            'ccynm_ru' => $model->currency->ccynm_ru,
                            'ccynm_en' => $model->currency->ccynm_en,
                        ],
                        'date' => $model->date,
                        'rate' => $model->rate
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
                        'model' => 'exchange_rate',
                        'created' => [
                            "id" => $model->id,
                            'currency' => [
                                'id' => $model->currency->id,
                                'code' => $model->currency->code,
                                'ccy' => $model->currency->ccy,
                                'ccynm_uz' => $model->currency->ccynm_uz,
                                'ccynm_uzc' => $model->currency->ccynm_uzc,
                                'ccynm_ru' => $model->currency->ccynm_ru,
                                'ccynm_en' => $model->currency->ccynm_en,
                            ],
                            'date' => $model->date,
                            'rate' => $model->rate
                        ]
                    ]
                ]);
        });
    }

}
