<?php

namespace App\GraphQL\Mutations\Cars;

use App\Models\User;

final class SetDefaultCar
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        /** @var User $user */
        $user = auth()->user();
        $cars = $user->cars()->get();

        foreach ($cars as $car) {
            $car->is_default = $car->id == $args['id'];
            $car->save();
        }

        return $cars->toArray();
    }
}
