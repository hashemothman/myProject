<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketerAccountInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'campany_name',
        'commercialRegister_photo',
        'commercialRegister_number',
    ];

    /**
     * Get the account that owns the MarketerAccountInfo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
