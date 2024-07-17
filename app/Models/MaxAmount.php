<?php

namespace App\Models;

use App\Models\Coin;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaxAmount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coin_id',
        'country_id',
        'account_type',
        'max_amount',
    ];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
