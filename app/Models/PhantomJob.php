<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/** @mixin Builder */
class PhantomJob extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'icon_url',
        'name',
    ];

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class)
            ->withPivot([
                'level', 'current_xp', 'max_xp', 'mastered'
            ])
            ->withTimestamps();
    }
}
