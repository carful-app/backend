<?php

namespace App\Listeners;

use App\Events\ParkCarCreated;
use App\Notifications\ParkCarNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationWithUpdates implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ParkCarCreated $event)
    {
        $parkCar = $event->parkCar;
        $user = $parkCar->user;

        $minutes = $parkCar->start_time->diffInMinutes($parkCar->end_time) - 60; // 60 minutes before end time

        for ($i = 0; $i < $minutes; $i++) {
            $user->notify((new ParkCarNotification($parkCar))->delay(now()->addMinutes($i)));
        }

        for ($i = 0; $i < 60 * 60; $i++) {
            $user->notify((new ParkCarNotification($parkCar))->delay(now()->addSeconds($i)));
        }
    }
}
