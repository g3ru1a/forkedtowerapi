<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
/** @mixin Builder */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'discord_id',
        'discord_username',
        'discord_nickname',
        'discord_avatar_url',
    ];

    public function characters(): HasMany {
        return $this->hasMany(Character::class);
    }

    public function groups_owned(): HasMany
    {
        return $this->hasMany(Group::class, 'owner_id');
    }

    public function groups_member(): BelongsToMany {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id');
    }
}
