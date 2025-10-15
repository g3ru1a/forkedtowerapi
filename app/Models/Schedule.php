<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'group_id',
        'host_id',
        'public',
        'date',
        'time',
        'description',
        'require_registration',
        'duration_hours',
        'type_id',
        'fight_id',
        'seat_count',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'time' => 'datetime:H:i',
    ];

    protected static function booted(): void
    {

        // runs AFTER insert (good for side-effects)
        static::created(function (Schedule $schedule) {
            if(!$schedule->getAttribute('public')) {
                $schedule->private_key = $schedule->group->private_path . '-' . str()->random(16);
                $schedule->saveOrFail();
            }
            $seat_count = $schedule->getAttribute('seat_count');
            for ($i = 0; $i < $seat_count; $i++) {
                $seat = new Seat([
                    'schedule_id' => $schedule->getAttribute('id'),
                    'number' => $i
                ]);
                $seat->saveOrFail();
            }
        });
    }


    public function fight(): BelongsTo
    {
        return $this->belongsTo(Fight::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function type(): HasOne
    {
        return $this->hasOne(RunType::class, 'id', 'type_id');
    }

    public function host(): HasOne
    {
        return $this->hasOne(Character::class, 'id', 'host_id');
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

}
