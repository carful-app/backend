<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneType extends Model
{
    use SlugTrait;

    protected $fillable = [
        'name',
        'slug',
    ];
}
