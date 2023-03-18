<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneCoordinate extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'zone_id',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
