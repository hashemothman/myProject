<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'account_id',
        'file',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
