<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MaxAmount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coin_id',
        'country_id',
        'account_type',
        'max_amount',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($max_amount) {
            $max_amount->user_id = Auth::user()->id;
        });
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
