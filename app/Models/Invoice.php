<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'officeInfo_id',
        'invoice_number',
        'date',
        'coin_id',
        'invoices_value',
        'file',
    ];

    public function officeInfo(): BelongsTo
    {
        return $this->belongsTo(OfficeInfo::class, 'officeInfo_id');
    }
}
