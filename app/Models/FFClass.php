<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FFClass extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'f_f_classes';
    protected $fillable = [
        'name',
        'icon_url',
        'type',
        'flat_icon_url',
        'type'
    ];

    public function registrations(): BelongsToMany
    {
        return $this->belongsToMany(Registration::class, 'registration_flex_classes', 'class_id', 'registration_id');
    }
}
