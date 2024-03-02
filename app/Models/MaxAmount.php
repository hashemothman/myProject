<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaxAmount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'coin_id',
        'country_id',
        'account_type',
        'max_amount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
