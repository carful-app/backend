<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use SlugTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }
}
