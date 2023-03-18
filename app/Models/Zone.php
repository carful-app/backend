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
        'slug',
        'city_id',
        'zone_type_id',
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

    public function coordsArray(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->coordinates->map(fn ($coordinate) => [
                $coordinate->latitude,
                $coordinate->longitude,
            ])->toArray(),
        );
    }
}
