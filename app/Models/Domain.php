<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'domains';
    protected $fillable = [
        'user_id',
        'url',
        'interval_minutes',
        'timeout_seconds',
        'method',
        'last_checked_at',
        'active'
    ];

    protected $casts = [
        'last_checked_at' => 'datetime',
    ];

    public const ALLOWED_METHODS = ['GET', 'HEAD'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class);
    }

    public function isReadyForCheck(): bool
    {
        if (!$this->last_checked_at) {
            return true;
        }

        $nextCheck = $this->last_checked_at->addMinutes($this->interval_minutes);

        return now()->gte($nextCheck);
    }
}
