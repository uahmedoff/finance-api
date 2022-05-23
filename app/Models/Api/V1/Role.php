<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole{
    use HasFactory, HasUuid;
}
