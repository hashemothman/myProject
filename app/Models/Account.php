<?php

namespace App\Models;

use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'account',
        'account_type',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function reports()
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

    /**
     *  put the account user id value equal to the Auth user id
     *
     * @return true
     */
    protected static function boot(){
        parent::boot();

        static::creating(function ($account){
            $account->user_id = Auth::user()->id;
            return true;
        });
    }
}
