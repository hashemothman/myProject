<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'city_id',
        'fullName',
        'idNumber',
        'photo',
        'front_card_image',
        'back_card_image',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($userInfo) {
            $authUser = Auth::guard('api')->user();
            if ($authUser) {
                $user_id = $authUser->id;
                $user = User::find($user_id);
                
                if ($user) {
                    $userInfo->user_id = $user->id;
                } else {
                    Log::error('User not found with ID: ' . $user_id);
                    throw new \Exception('User not found.');
                }
            } else {
                Log::error('No authenticated user found.');
                throw new \Exception('No authenticated user found.');
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
