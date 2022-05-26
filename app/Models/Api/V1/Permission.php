<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use App\Models\Traits\TimezoneTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission{
    use HasFactory, 
        HasUuid, 
        ScopeTrait,
        TimezoneTrait;
    
    private $search_columns = [
        'name',
    ];

    public function scopeWithRolesIfRequested($query){
        if (request('with_roles')){
            $query = $query->with('roles');
        }
        return $query;
    }

    public function scopeFilterRole($query,$role_id){
        if ($filter = $role_id){
            $query = $query->whereHas('roles',function($q) use ($filter){
                $q->where('id',$filter);
            });
        }
        return $query;
    }

}
