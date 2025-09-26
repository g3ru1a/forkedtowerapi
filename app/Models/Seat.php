<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'number',
        'character_id',
        'class_id',
        'registration_id',
        'is_raidlead',
        'is_helper',
        'phantom_job_id'
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function character(): HasOne
    {
        return $this->hasOne(Character::class);
    }

    public function phantom_job(): BelongsTo
    {
        return $this->belongsTo(PhantomJob::class);
    }

    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class);
    }

    public function ffclass(): HasOne
    {
        return $this->hasOne(FFClass::class, 'id', 'class_id');
    }
}
