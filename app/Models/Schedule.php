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
        'public',
        'date',
        'time',
        'description',
        'registration_open',
        'registration_deadline',
        'type_id',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'time' => 'datetime:H:i',
    ];

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

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
