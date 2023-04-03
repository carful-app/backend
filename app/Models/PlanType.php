<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanType extends Model
{
    use SlugTrait;

    const ONE_TIME_USE = 'one_time_use';
    const MONTHLY = 'monthly';

    protected $fillable = [
        'name',
        'slug',
    ];
}
