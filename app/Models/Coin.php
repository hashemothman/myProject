<?php

namespace App\Models;

use App\Models\Percent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coin_name',
        'country_flag',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'coin_id', 'id');
    }

    public function maxAmount(): HasOne
    {
        return $this->hasOne(MaxAmount::class, 'coin_id', 'id');
    }
    public function percent(): HasMany
    {
        return $this->hasMany(Percent::class, 'coin_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'coin_id', 'id');
    }

}
