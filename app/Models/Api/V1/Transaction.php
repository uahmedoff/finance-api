<?php

namespace App\Models\Api\V1;

use App\Models\Traits\HasUuid;
use App\Models\Traits\ScopeTrait;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends BaseModel{

    use HasFactory, 
        HasUuid, 
        ScopeTrait, 
        Userstamps, 
        SoftDeletes;

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

    private $search_columns = [
    
    ];

    public function scopeFilter($query){
        if ($filter = request('wallet_id')){
            $query = $query->where('wallet_id', $filter);
        }
        if ($filter = request('category_id')){
            $query = $query->where('category_id', $filter);
        }
        if ($filter = request('payment_method_id')){
            $query = $query->where('payment_method_id', $filter);
        }
        if ($filter = request('date')){
            $query = $query->where('date', $filter);
        }
        if ($filter = request('debit')){
            $query = $query->where('debit', $filter);
        }
        if ($filter = request('credit')){
            $query = $query->where('credit', $filter);
        }
        if ($filter = request('note')){
            $query = $query->where('note','ilike','%' .  $filter . '%');
        }
        return $query;
    }

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

    public static function boot(){
        parent::boot();
        static::created(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_CREATED,
                'details' => [
                    'transaction' => [
                        'wallet_id' => $model->wallet_id,
                        'category_id' => $model->category_id,
                        'payment_method_id' => $model->payment_method_id,
                        'date' => $model->date,
                        'debit' => $model->debit,
                        'credit' => $model->credit,
                        'image' => $model->image,
                        'note' => $model->note
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
                        'model' => 'transaction',
                        'created' => [
                            "id" => $model->id,
                            'wallet_id' => $model->wallet_id,
                            'category_id' => $model->category_id,
                            'payment_method_id' => $model->payment_method_id,
                            'date' => $model->date,
                            'debit' => $model->debit,
                            'credit' => $model->credit,
                            'image' => $model->image,
                            'note' => $model->note
                        ]
                    ]
                ]);
        });
        static::updating(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_UPDATED,
                'details' => [
                    'old_data' => [
                        'wallet_id' => $model->getOriginal('wallet_id'),
                        'category_id' => $model->getOriginal('category_id'),
                        'payment_method_id' => $model->getOriginal('payment_method_id'),
                        'date' => $model->getOriginal('date'),
                        'debit' => $model->getOriginal('debit'),
                        'credit' => $model->getOriginal('credit'),
                        'image' => $model->getOriginal('image'),
                        'note' => $model->getOriginal('note'),
                    ],
                    'new_data' => [
                        'wallet_id' => request('wallet_id'),
                        'category_id' => request('category_id'),
                        'payment_method_id' => request('payment_method_id'),
                        'date' => request('date'),
                        'debit' => request('debit'),
                        'credit' => request('credit'),
                        'image' => request('image'),
                        'note' => request('note'),                        
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
                        'model' => 'transaction',
                        'updated' => [
                            "id" => $model->id,
                            'old_data' => [
                                'wallet_id' => $model->getOriginal('wallet_id'),
                                'category_id' => $model->getOriginal('category_id'),
                                'payment_method_id' => $model->getOriginal('payment_method_id'),
                                'date' => $model->getOriginal('date'),
                                'debit' => $model->getOriginal('debit'),
                                'credit' => $model->getOriginal('credit'),
                                'image' => $model->getOriginal('image'),
                                'note' => $model->getOriginal('note'),
                            ],
                            'new_data' => [
                                'wallet_id' => request('wallet_id'),
                                'category_id' => request('category_id'),
                                'payment_method_id' => request('payment_method_id'),
                                'date' => request('date'),
                                'debit' => request('debit'),
                                'credit' => request('credit'),
                                'image' => request('image'),
                                'note' => request('note'),                        
                            ],
                        ]
                    ]
                ]);
        });
        static::deleted(function ($model) {
            $model->history()->create([
                'status' => History::STATUS_MODEL_DELETED,
                'details' => [
                    'transaction' => [
                        'wallet_id' => $model->wallet_id,
                        'category_id' => $model->category_id,
                        'payment_method_id' => $model->payment_method_id,
                        'date' => $model->date,
                        'debit' => $model->debit,
                        'credit' => $model->credit,
                        'image' => $model->image,
                        'note' => $model->note
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
                        'model' => 'transaction',
                        'deleted' => [
                            'wallet_id' => $model->wallet_id,
                            'category_id' => $model->category_id,
                            'payment_method_id' => $model->payment_method_id,
                            'date' => $model->date,
                            'debit' => $model->debit,
                            'credit' => $model->credit,
                            'image' => $model->image,
                            'note' => $model->note
                        ]
                    ]
                ]);
        });
    }

}
