<?php

namespace App\Models;

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
}
