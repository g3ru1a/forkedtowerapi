<?php

namespace App\Models;

use Dom\CharacterData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/** @mixin Builder */

class Character extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'lodestone_id',
        'name',
        'world',
        'datacenter',
        'avatar_url',
        'verification_code',
        'is_verified',
        'attempts',
        'expires_at',
        'verified_at'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function occult_data(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OccultData::class);
    }

    public function phantom_jobs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PhantomJob::class)
            ->withPivot([
                'level', 'current_xp', 'max_xp', 'mastered'
            ])
            ->withTimestamps();
    }
}
