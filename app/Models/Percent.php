<?php

namespace App\Models;

use App\Models\Coin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Percent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'operation_type',
        'coin_id',
        'value',
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
