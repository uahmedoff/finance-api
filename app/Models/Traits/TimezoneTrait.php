<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait TimezoneTrait{
    
    public function getCreatedAtAttribute($value){
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->toDateTimeString();
    }

    public function getDeletedAtAttribute($value){
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->toDateTimeString();
    }
    
}