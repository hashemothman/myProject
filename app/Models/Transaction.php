<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coin_id',
        'sender',
        'reciever_account',
        'amount',
        // TODO: type of operation 
        // 'type',
        'date',
    ];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($transaction) {
            $transaction->sender = Auth::user()->id;
            return true;
        });
        self::observe(TransactionObserver::class);

    }



}
