<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    use SlugTrait;

    const BASIC_MONTHLY = 'basic_mountly';
    const STANDARD_MONTHLY = 'standard_mountly';
    const PREMIUM_MONTHLY = 'premium_mountly';

    const BASIC_ONE_TIME_USE = 'basic_one_time_use';
    const STANDARD_ONE_TIME_USE = 'standard_one_time_use';
    const PREMIUM_ONE_TIME_USE = 'premium_one_time_use';

    const MONTHLY = [
        self::BASIC_MONTHLY,
        self::STANDARD_MONTHLY,
        self::PREMIUM_MONTHLY,
    ];

    const ONE_TIME_USE = [
        self::BASIC_ONE_TIME_USE,
        self::STANDARD_ONE_TIME_USE,
        self::PREMIUM_ONE_TIME_USE,
    ];

    protected $fillable = [
        'name',
        'slug',
        'price',
        'plan_type_id',
        'uses',
    ];

    public function planType(): BelongsTo
    {
        return $this->belongsTo(PlanType::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function priceFormated(): Attribute
    {
        return Attribute::make(
            get: fn () =>
            in_array($this->currency->slug, Currency::BACK_CURRENCIES)
                ? ($this->price . ' ' . $this->currency->symbol)
                : (in_array($this->currency->slug, Currency::FRONT_CURRENCIES)
                    ? ($this->currency->symbol . ' ' . $this->price)
                    : $this->price
                ),

            set: fn ($value) => in_array($this->currency->slug, Currency::BACK_CURRENCIES)
                ? $this->price = (float)str_replace(' ' . $this->currency->symbol, '', $value)
                : (in_array($this->currency->slug, Currency::FRONT_CURRENCIES)
                    ? $this->price = (float)str_replace($this->currency->symbol . ' ', '', $value)
                    : $this->price = (float)$value
                ),
        );
    }
}
