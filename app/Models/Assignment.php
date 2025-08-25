<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/** @mixin Builder */
class Assignment extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'user_id',
        'character_id',
        'seat',
        'class',
        'job',
        'is_lead',
        'is_absent',
        'did_participate'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
