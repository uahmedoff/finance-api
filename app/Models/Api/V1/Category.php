<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel{
    
    use HasFactory, 
        HasUuid, 
        ScopeTrait, 
        Userstamps, 
        SoftDeletes;

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

    private $search_columns = [
        'name'
    ];

    public function scopeFilter($query){
        if ($filter = request('wallet_id')){
            $query = $query->where('wallet_id', $filter);
        }
        if ($filter = request('parent_id')){
            $query = $query->where('parent_id', $filter);
        }
        if ($filter = request('name')){
            $query = $query->where('name','like','%' .  $filter . '%');
        }
        if ($filter = request('color')){
            $query = $query->where('color',$filter);
        }
        if ($filter = request('bgcolor')){
            $query = $query->where('bgcolor',$filter);
        }
        if ($filter = request('type')){
            $query = $query->where('type',$filter);
        }
        if ($filter = request('ccynm_en')){
            $query = $query->where('ccynm_en','like','%' .  $filter . '%');
        }
        return $query;
    }

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

    public static function boot(){
        parent::boot();
        static::created(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_CREATED,
                'details' => [
                    'category' => [
                        "name" => $model->name,
                        "wallet_id" => $model->wallet_id,
                        "icon" => $model->icon,
                        "color" => $model->color,
                        "bgcolor" => $model->bgcolor,
                        "type" => $model->type,
                        "parent_id" => $model->parent_id
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
                        'model' => 'category',
                        'created' => [
                            "id" => $model->id,
                            "name" => $model->name,
                            "wallet_id" => $model->wallet_id,
                            "icon" => $model->icon,
                            "color" => $model->color,
                            "bgcolor" => $model->bgcolor,
                            "type" => $model->type,
                            "parent_id" => $model->parent_id
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
                        "wallet_id" => $model->getOriginal('wallet_id'),
                        "icon" => $model->getOriginal('icon'),
                        "color" => $model->getOriginal('color'),
                        "bgcolor" => $model->getOriginal('bgcolor'),
                        "type" => $model->getOriginal('type'),
                        "parent_id" => $model->getOriginal('parent_id')
                    ],
                    'new_data' => [
                        "name" => request('name'),
                        "wallet_id" => request('wallet_id'),
                        "icon" => request('icon'),
                        "color" => request('color'),
                        "bgcolor" => request('bgcolor'),
                        "type" => request('type'),
                        "parent_id" => request('parent_id')
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
                        'model' => 'category',
                        'updated' => [
                            "id" => $model->id,
                            'old_data' => [
                                "name" => $model->getOriginal('name'),
                                "wallet_id" => $model->getOriginal('wallet_id'),
                                "icon" => $model->getOriginal('icon'),
                                "color" => $model->getOriginal('color'),
                                "bgcolor" => $model->getOriginal('bgcolor'),
                                "type" => $model->getOriginal('type'),
                                "parent_id" => $model->getOriginal('parent_id')
                            ],
                            'new_data' => [
                                "name" => request('name'),
                                "wallet_id" => request('wallet_id'),
                                "icon" => request('icon'),
                                "color" => request('color'),
                                "bgcolor" => request('bgcolor'),
                                "type" => request('type'),
                                "parent_id" => request('parent_id')
                            ],
                        ]
                    ]
                ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'category' => [
                        "name" => $model->name,
                        "wallet_id" => $model->wallet_id,
                        "icon" => $model->icon,
                        "color" => $model->color,
                        "bgcolor" => $model->bgcolor,
                        "type" => $model->type,
                        "parent_id" => $model->parent_id
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
                        'model' => 'category',
                        'deleted' => [
                            'id' => $model->id,
                            "name" => $model->name,
                            "wallet_id" => $model->wallet_id,
                            "icon" => $model->icon,
                            "color" => $model->color,
                            "bgcolor" => $model->bgcolor,
                            "type" => $model->type,
                            "parent_id" => $model->parent_id
                        ]
                    ]
                ]);
        });
    }
}
