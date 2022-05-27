<?php

namespace App\Models\Api\V1;

use App\Models\Api\V1\Role;
use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use App\Models\Traits\TimezoneTrait;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Chelout\RelationshipEvents\Concerns\HasMorphToManyEvents;

class User extends Authenticatable implements JWTSubject{
    
    use HasFactory, 
        Notifiable, 
        HasUuid, 
        HasRoles, 
        Userstamps, 
        SoftDeletes, 
        ScopeTrait, 
        HasMorphToManyEvents, 
        TimezoneTrait;

    protected $fillable = [
        'phone',
        'name', 
        'password',
        'lang'
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    protected $casts = [
    ];

    private $search_columns = [
        'phone',
        'name',
    ];

    public function scopeFilter($query){
        if ($filter = request('name')){
            $query = $query->where('name','ilike','%' .  $filter . '%');
        }
        if ($filter = request('phone')){
            $query = $query->where('phone','ilike','%' .  $filter . '%');
        }
        if ($filter = request('lang')){
            $query = $query->where('lang',$filter);
        }
        return $query;
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function wallets(){
        return $this->belongsToMany(Wallet::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }

    protected static function boot(){
        parent::boot();
        static::created(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_CREATED,
                'details' => [
                    'user' => [
                        'name' => $model->name,
                        'phone' => $model->phone,
                        'lang' => $model->lang,
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
                    'historiable_type' => self::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_CREATED_BY_USER,
                    'details' => [
                        'model' => 'user',
                        'created' => [
                            'id' => $model->id,
                            'name' => $model->name,
                            'phone' => $model->phone,
                            'lang' => $model->lang,
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
                        'phone' => $model->getOriginal('phone'),
                        'lang' => $model->getOriginal('lang'),
                    ],
                    'new_data' => [
                        'name' => request('name'),
                        'phone' => request('phone'),
                        'lang' => request('lang'),
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
                    'historiable_type' => self::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_UPDATED_BY_USER,
                    'details' => [
                        'model' => 'user',
                        'updated' => [
                            'id' => $model->id,
                            'old_data' => [
                                'name' => $model->getOriginal('name'),
                                'phone' => $model->getOriginal('phone'),
                                'lang' => $model->getOriginal('lang'),
                            ],
                            'new_data' => [
                                'name' => request('name'),
                                'phone' => request('phone'),
                                'lang' => request('lang'),
                            ],
                        ]
                    ]
                ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'user' => [
                        'name' => $model->name,
                        'phone' => $model->phone,
                        'lang' => $model->lang,
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
                    'historiable_type' => self::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_DELETED_BY_USER,
                    'details' => [
                        'model' => 'user',
                        'deleted' => [
                            'id' => $model->id,
                            'name' => $model->name,
                            'phone' => $model->phone,
                            'lang' => $model->lang,
                        ]
                    ]
                ]);
        });
        static::morphToManyAttached(function ($relation, $parent, $ids, $attributes) {
            $role = Role::find($ids[0]);
            History::create([
                'historiable_type' => self::class,
                'historiable_id' => $parent->id,
                'status' => History::STATUS_ROLE_ATTACHED,
                'details' => [
                    'role' => [
                        'id' => $role->id,
                        'name' => $role->name
                    ],
                    'attached_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : []
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => self::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_ROLE_ATTACHED_BY,
                    'details' => [
                        'user' => [
                            'id' => $parent->id,
                            'name' => $parent->name,
                            'phone' => $parent->phone
                        ],
                        'role' => [
                            'id' => $role->id,
                            'name' => $role->name
                        ],
                    ]
                ]);
        });
        static::morphToManyDetached(function ($relation, $parent, $ids, $attributes) {
            $role = Role::find($ids[0]);
            History::create([
                'historiable_type' => self::class,
                'historiable_id' => $parent->id,
                'status' => History::STATUS_ROLE_DETACHED,
                'details' => [
                    'role' => [
                        'id' => $role->id,
                        'name' => $role->name
                    ],
                    'detached_by' => (auth()->user()) ? [
                        'id' => auth()->user()->id,
                        'name' => auth()->user()->name,
                        'phone' => auth()->user()->phone
                    ] : []
                ]
            ]);
            if(auth()->user())
                History::create([
                    'historiable_type' => self::class,
                    'historiable_id' => auth()->user()->id,
                    'status' => History::STATUS_ROLE_DETACHED_BY,
                    'details' => [
                        'user' => [
                            'id' => $parent->id,
                            'name' => $parent->name,
                            'phone' => $parent->phone
                        ],
                        'role' => [
                            'id' => $role->id,
                            'name' => $role->name
                        ],
                    ]
                ]);
        });
    }
}