<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_players',
        'max_players',
    ];
}
