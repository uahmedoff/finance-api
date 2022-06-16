<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends BaseModel{
    
    use HasFactory, 
        HasUuid, 
        ScopeTrait, 
        Userstamps, 
        SoftDeletes,
        HasBelongsToManyEvents;

    protected $fillable = [
        'name',
        'project_api_url',
        'currency_id',
        'parent_id',
        'firm_id',
    ];

    private $search_columns = [
        'name',
        'project_api_url'
    ];

    public function scopeFilter($query){
        if ($filter = request('name')){
            $query = $query->where('name', 'like','%' .  $filter . '%');
        }
        if ($filter = request('project_api_url')){
            $query = $query->where('project_api_url','like','%' .  $filter . '%');
        }
        if ($filter = request('currency_id')){
            $query = $query->where('currency_id',$filter);
        }
        if ($filter = request('parent_id')){
            $query = $query->where('parent_id',$filter);
        }
        if ($filter = request('firm_id')){
            $query = $query->where('firm_id',$filter);
        }
        return $query;
    }

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

    public static function boot(){
        parent::boot();
        static::created(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_CREATED,
                'details' => [
                    'wallet' => [
                        'name' => $model->name,
                        'project_api_url' => $model->api_url,
                        'currency_id' => $model->currency_id,
                        'parent_id' => $model->parent_id,
                        'firm_id' => $model->firm_id,
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
                        'model' => 'wallet',
                        'created' => [
                            "id" => $model->id,
                            'name' => $model->name,
                            'project_api_url' => $model->api_url,
                            'currency_id' => $model->currency_id,
                            'parent_id' => $model->parent_id,
                            'firm_id' => $model->firm_id,
                        ]
                    ]
                ]);
        });
        static::updating(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_UPDATED,
                'details' => [
                    'old_data' => [
                        'name' => $model->getOriginal('name'),
                        'project_api_url' => $model->getOriginal('api_url'),
                        'currency_id' => $model->getOriginal('currency_id'),
                        'parent_id' => $model->getOriginal('parent_id'),
                        'firm_id' => $model->getOriginal('firm_id'),
                    ],
                    'new_data' => [
                        'name' => request('name'),
                        'project_api_url' => request('api_url'),
                        'currency_id' => request('currency_id'),
                        'parent_id' => request('parent_id'),
                        'firm_id' => request('firm_id'),
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
                        'model' => 'wallet',
                        'updated' => [
                            "id" => $model->id,
                            'old_data' => [
                                'name' => $model->getOriginal('name'),
                                'project_api_url' => $model->getOriginal('api_url'),
                                'currency_id' => $model->getOriginal('currency_id'),
                                'parent_id' => $model->getOriginal('parent_id'),
                                'firm_id' => $model->getOriginal('firm_id'),
                            ],
                            'new_data' => [
                                'name' => request('name'),
                                'project_api_url' => request('api_url'),
                                'currency_id' => request('currency_id'),
                                'parent_id' => request('parent_id'),
                                'firm_id' => request('firm_id'),
                            ],
                        ]
                    ]
                ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'wallet' => [
                        'name' => $model->name,
                        'project_api_url' => $model->api_url,
                        'currency_id' => $model->currency_id,
                        'parent_id' => $model->parent_id,
                        'firm_id' => $model->firm_id,
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
                        'model' => 'wallet',
                        'deleted' => [
                            'id' => $model->id,
                            'name' => $model->name,
                            'project_api_url' => $model->api_url,
                            'currency_id' => $model->currency_id,
                            'parent_id' => $model->parent_id,
                            'firm_id' => $model->firm_id,
                        ]
                    ]
                ]);
        });
        static::belongsToManyAttached(function ($relation, $parent, $ids) {
            $users = User::whereIn('id',$ids)->get(['id','name','phone']);
            History::create([
                'historiable_type' => self::class,
                'historiable_id' => $parent->id,
                'status' => History::STATUS_USER_ATTACHED_TO_WALLET,
                'details' => [
                    'users' => $users,
                    'attached_by' => (auth()->user()) ? [
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
                    'status' => History::STATUS_USER_ATTACHED_TO_WALLET_BY,
                    'details' => [
                        'wallet' => [
                            'id' => $parent->id,
                            'name' => $parent->name,
                        ],
                        'users' => $users,
                    ]
                ]);
        });
        static::belongsToManyDetached(function ($relation, $parent, $ids) {
            $users = User::whereIn('id',$ids)->get(['id','name','phone']);
            History::create([
                'historiable_type' => self::class,
                'historiable_id' => $parent->id,
                'status' => History::STATUS_USER_DETACHED_FROM_WALLET,
                'details' => [
                    'users' => $users,
                    'detached_by' => (auth()->user()) ? [
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
                    'status' => History::STATUS_USER_DETACHED_FROM_WALLET_BY,
                    'details' => [
                        'wallet' => [
                            'id' => $parent->id,
                            'name' => $parent->name,
                        ],
                        'users' => $users,
                    ]
                ]);
        });
    }
}
