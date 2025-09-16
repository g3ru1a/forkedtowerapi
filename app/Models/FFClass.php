<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
