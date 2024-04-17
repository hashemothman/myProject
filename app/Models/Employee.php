<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'name',
        'id_namber',
        'front_card_image',
        'back_card_image',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($employee) {
            $employee->admin_id = Auth::guard('admin-api')->user()->id;
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
