<?php

namespace App\GraphQL\Mutations;

final class SetDefaultCar
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $cars = auth()->user()->cars()->get();

        foreach ($cars as $car) {
            $car->is_default = $car->id == $args['id'];
            $car->save();
        }

        return $cars->toArray();
    }
}
