<?php

namespace App\GraphQL\Queries\Parking;

use App\Services\ParkCarService;

final class ParkCar
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function getLastParkCar($_, array $args)
    {
        return ParkCarService::getLastParkCar(auth()->user());
    }
}
