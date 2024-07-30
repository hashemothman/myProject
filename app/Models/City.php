<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city',
        'is_active',
    ];

    public function officeInfos(): HasMany
    {
        return $this->hasMany(OfficeInfo::class, 'city_id', 'id');
    }

    public function userInfos(): HasMany
    {
        return $this->hasMany(UserInfo::class, 'city_id', 'id');
    }
}
