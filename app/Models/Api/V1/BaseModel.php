<?php

namespace App\Models\Api\V1;

use App\Models\Traits\TimezoneTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BaseModel extends Model{
    
    use HasFactory, 
        TimezoneTrait;

}
