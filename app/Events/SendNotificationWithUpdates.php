<?php

namespace App\Events;

use App\Models\ParkCar;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationWithUpdates
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public ParkCar $parkCar)
    {
    }
}
