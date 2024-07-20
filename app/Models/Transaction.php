<?php

namespace App\Models;

use Carbon\Carbon;
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
        'type',
        'date',
        'transactionable_id',
        'transactionable_type'
    ];

     // Define the polymorphic relationship
    public function transactionable()
    {
        return $this->morphTo();
    }
    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($transaction) {
            $isUserAdmin = Auth::guard('admin-api')->check();
            if ($isUserAdmin) {
                $admin =  Auth::guard('admin-api')->user();
                $transaction->sender = $admin->id;
            } else {
                $transaction->sender = Auth::user()->id;
            }
            $transaction->date = Carbon::now()->format('Y-m-d H:i:s');
            return true;
        });
        self::observe(TransactionObserver::class);
    }



}
