<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AdminWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'coin_id',
        'amount',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($adminWallet) {
            $adminWallet->admin_id = Auth::guard('admin-api')->user()->id;
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }
}
