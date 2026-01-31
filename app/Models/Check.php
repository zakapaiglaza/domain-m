<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Check extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'checked_at',
        'success',
        'status_code',
        'response_time_ms',
        'error_message',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
        'success' => 'boolean',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }
}
