<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coin_id',
        'senser',
        'reciever_uuid',
        'amount',
        'date',
    ];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
