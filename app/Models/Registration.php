<?php

namespace App\Models;

use App\Pivots\RegistrationClass;
use App\Pivots\RegistrationJobs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/** @mixin Builder */
class Registration extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'user_id',
        'character_id',
        'preferred_class_id',
        'preferred_job_id',
        'can_solo_heal',
        'can_english',
        'can_markers',
        'notes',
        'status',
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

    public function preferred_class(): BelongsTo
    {
        return $this->belongsTo(FFClass::class, 'preferred_class_id');
    }

    public function preferred_job(): BelongsTo
    {
        return $this->belongsTo(PhantomJob::class, 'preferred_job_id');
    }

    public function flex_classes(): BelongsToMany
    {
        return $this
            ->belongsToMany(FFClass::class, 'registration_flex_classes', 'registration_id', 'class_id')
            ->using(RegistrationClass::class)
            ->withTimestamps();
    }

    public function flex_jobs(): BelongsToMany
    {
        return $this->belongsToMany(PhantomJob::class, 'registration_flex_jobs', 'registration_id', 'job_id')
            ->using(RegistrationJobs::class)
            ->withTimestamps();
    }
}
