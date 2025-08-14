<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/** @mixin Builder */
class OccultData extends Model
{
    use HasUuids, HasFactory, SoftDeletes;

    protected $fillable = [
        'character_id',
        'knowledge_level',
        'phantom_mastery',
        'phantom_jobs'
    ];

    public function character(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
