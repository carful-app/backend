<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    protected $fillable = [
        'name',
        'city_id',
        'zone_type_id',
        'min_hour',
        'max_hour',
        'hour_interval',
        'start_time',
        'end_time',
        'start_day_of_week_id',
        'end_day_of_week_id',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    public function coordinates(): HasMany
    {
        return $this->hasMany(ZoneCoordinate::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function zoneType(): BelongsTo
    {
        return $this->belongsTo(ZoneType::class);
    }

    public function startDay(): BelongsTo
    {
        return $this->belongsTo(DayOfWeek::class, 'start_day_of_week_id');
    }

    public function endDay(): BelongsTo
    {
        return $this->belongsTo(DayOfWeek::class, 'end_day_of_week_id');
    }

    public function coordsArray(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->coordinates->map(fn ($coordinate) => [
                $coordinate->latitude,
                $coordinate->longitude,
            ])->toArray(),
        );
    }

    public function hours(): Attribute
    {
        return Attribute::make(
            get: fn () => range($this->min_hour, $this->max_hour, $this->hour_interval),
        );
    }
}
