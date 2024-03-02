<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'role_name'
    ];


    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'admin_id', 'id');
    }
}
