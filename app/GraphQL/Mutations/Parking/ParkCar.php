<?php

namespace App\GraphQL\Mutations\Parking;

use App\Models\Car;
use App\Models\User;
use App\Services\ParkCarService;

final class ParkCar
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function parkCar($_, array $args)
    {
        /** @var User $user */
        $user = auth()->user();
        $car = Car::find($args['carId']);
        $hours = $args['hours'];
        $latitude = $args['latitude'];
        $longitude = $args['longitude'];

        return ParkCarService::parkCar($user, $car, $hours, $latitude, $longitude);
    }

    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function addTime($_, array $args)
    {
        $parkCar = ParkCarService::getLastParkCar(auth()->user());

        return ParkCarService::addTime($parkCar, $args['hours']);
    }
}
