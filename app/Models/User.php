<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Wallet;
use App\Models\Account;
use App\Models\UserLog;
use App\Models\Complain;
use App\Models\UserInfo;
use App\Models\MaxAmount;
use App\Models\Transaction;
use App\Models\BussinessAccount;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles ,SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'mobile_number',
        'status',
        'type',
        'password',
        'fcm_token',
        'role_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Get all of the roles for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */



    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'user_id');
    }

    public function userInfo(): HasOne
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function bussinessAccount(): HasOne
    {
        return $this->hasOne(BussinessAccount::class, 'user_id');
    }

    public function maxAmounts(): HasMany
    {
        return $this->hasMany(MaxAmount::class, 'user_id');
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class, 'user_id');
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complain::class, 'user_id');
    }

    public function userLogs(): HasMany
    {
        return $this->hasMany(UserLog::class, 'user_id');
    }

    public function transactions()
{
    return $this->morphMany(Transaction::class, 'transactionable');
}
}
