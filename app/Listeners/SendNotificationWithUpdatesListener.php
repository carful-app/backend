<?php

namespace App\Listeners;

use App\Events\SendNotificationWithUpdates;
use App\Notifications\ParkCarNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationWithUpdatesListener implements ShouldQueue
{
    public $afterCommit = true;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'web-push-queue';


    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 1;

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
    public function handle(SendNotificationWithUpdates $event)
    {
        $parkCar = $event->parkCar;
        $user = $parkCar->user;

        $diff = now()->diff($parkCar->end_time);

        $user->notify(new ParkCarNotification($parkCar, $diff));

        if ($diff->invert == 1) {
            return;
        }

        SendNotificationWithUpdates::dispatch($parkCar);
    }
}
