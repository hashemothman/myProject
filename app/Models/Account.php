<?php

namespace App\Models;

use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'account',
        'account_type',
        // 'q_rcode',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'account_id', 'id');
    }

    /**
     * Get the marketer_account_info associated with the Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function marketer_account_info(): HasOne
    {
        return $this->hasOne(MarketerAccountInfo::class, 'account_id', 'id');
    }

}
