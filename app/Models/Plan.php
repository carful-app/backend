<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Cashier\Cashier;

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
        'stripe_id',
    ];

    public function planType(): BelongsTo
    {
        return $this->belongsTo(PlanType::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (in_array($this->currency->slug, Currency::BACK_CURRENCIES)) {
                    return $this->price . ' ' . $this->currency->symbol;
                }

                if (in_array($this->currency->slug, Currency::FRONT_CURRENCIES)) {
                    return $this->currency->symbol . ' ' . $this->price;
                }

                return $this->price;
            },

            set: function ($value) {
                if (in_array($this->currency->slug, Currency::BACK_CURRENCIES)) {
                    $this->price = (float)str_replace(' ' . $this->currency->symbol, '', $value);
                }

                if (in_array($this->currency->slug, Currency::FRONT_CURRENCIES)) {
                    $this->price = (float)str_replace($this->currency->symbol . ' ', '', $value);
                }

                return $this->price = (float)$value;
            },
        );
    }
}
