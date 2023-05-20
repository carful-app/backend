<?php

namespace App\Services;

use App\Enum\TransactionType;
use App\Models\Car;
use App\Models\ParkCar;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ParkCarService
{
    public static function parkCar(User $user, Car $car, int $hours, float $latitude, float $longitude): ParkCar
    {
        $startTime = now();
        $endTime = now()->addHours($hours);

        try {
            DB::beginTransaction();

            $transaction = $user->transactions()->create([
                'type' => TransactionType::PAYMENT,
                'amount' => $hours,
            ]);

            $parkCar = ParkCar::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            $parkCar->transactions()->attach($transaction);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $parkCar;
    }

    public static function getLastParkCar(User $user): ?ParkCar
    {
        $now = now();

        return $user
            ->parkCars()
            ->latest()
            ->where('start_time', '<', $now)
            ->where('end_time', '>', $now)
            ->first();
    }
}
