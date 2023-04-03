<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use SlugTrait;

    const USD = 'usd';
    const EUR = 'eur';
    const BGN = 'bgn';

    const FRONT_CURRENCIES = [
        self::USD,
        self::EUR,
    ];

    const BACK_CURRENCIES = [
        self::BGN,
    ];

    protected $fillable = [
        'name',
        'symbol',
        'slug',
    ];
}
