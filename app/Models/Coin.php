<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'coin_name',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'coin_id', 'id');
    }

    public function maxAmount(): HasOne
    {
        return $this->hasOne(MaxAmount::class, 'coin_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'coin_id', 'id');
    }

}
