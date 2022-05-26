<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use App\Models\Traits\TimezoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Chelout\RelationshipEvents\Concerns\HasBelongsToManyEvents;

class Role extends SpatieRole{
    use HasFactory, 
        HasUuid, 
        ScopeTrait,
        TimezoneTrait,
        HasBelongsToManyEvents;

    private $search_columns = [
        'name',
    ];

    public function scopeWithPermissionsIfRequested($query){
        if (request('with_permissions')){
            $query = $query->with('permissions');
        }
        return $query;
    }
    
    protected static function boot(){
        parent::boot();
        static::belongsToManySynced(function ($relation, $parent, $ids) {
            $permissions = Permission::whereIn('id',$ids)->get(['id','name']);
            History::create([
                'historiable_type' => self::class,
                'historiable_id' => $parent->id,
                'status' => History::STATUS_PERMISSION_SYNCED,
                'details' => [
                    'permissions' => $permissions,
                    'synced_by' => (auth()->user()) ? [
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
                    'status' => History::STATUS_PERMISSION_SYNCED_BY,
                    'details' => [
                        'role' => [
                            'id' => $parent->id,
                            'name' => $parent->name,
                        ],
                        'permissions' => $permissions,
                    ]
                ]);
        });
    }    
}
