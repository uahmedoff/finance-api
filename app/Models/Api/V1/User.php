<?php

namespace App\Models\Api\V1;

use App\Models\Api\V1\Role;
use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
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
    
    use HasFactory, Notifiable, HasUuid, HasRoles, Userstamps, SoftDeletes, ScopeTrait, HasMorphToManyEvents;

    const LANGUAGE_UZBEK = 1;
    const LANGUAGE_RUSSIAN = 2;
    const LANGUAGE_ENGLISH = 3;

    protected $fillable = [
        'phone',
        'name', 
        'email', 
        'password',
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
        if ($filter = request('language_id')){
            $query = $query->where('language_id',$filter);
        }
        return $query;
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    protected static function boot(){
        parent::boot();
        static::created(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_CREATED,
                'details' => [
                    'name' => $model->name,
                    'phone' => $model->phone,
                    'lang' => $model->lang,
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
                ]
            ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'id' => $model->id,
                    'name' => $model->name,
                    'phone' => $model->phone,
                    'lang' => $model->lang,
                ]
            ]);
        });
        static::morphToManyAttached(function ($relation, $parent, $ids, $attributes) {
            History::create([
                'historiable_type' => 'App\Models\Api\V1\User',
                'historiable_id' => $parent->id,
                'status' => History::STATUS_ROLE_ATTACHED,
                'details' => [
                    'role' => [
                        'id' => Role::find($ids[0])->id,
                        'name' => Role::find($ids[0])->name
                    ]
                ]
            ]);
        });
        static::morphToManyDetached(function ($relation, $parent, $ids, $attributes) {
            History::create([
                'historiable_type' => 'App\Models\Api\V1\User',
                'historiable_id' => $parent->id,
                'status' => History::STATUS_ROLE_DETACHED,
                'details' => [
                    'role' => [
                        'id' => Role::find($ids[0])->id,
                        'name' => Role::find($ids[0])->name
                    ]
                ]
            ]);
        });
    }

    public function wallets(){
        return $this->belongsToMany(Wallet::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }

}