<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Transaction extends Model{

    use HasFactory, HasUuid, Userstamps, SoftDeletes;

    protected $fillable = [
        'wallet_id',
        'category_id',
        'payment_method_id',
        'date',
        'debit',
        'credit',
        'image',
        'note'
    ];

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function history(){
        return $this->morphMany(History::class, 'historiable');
    }

}
