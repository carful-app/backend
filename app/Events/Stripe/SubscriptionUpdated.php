<?php

namespace App\Events\Stripe;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Stripe\Event;

class SubscriptionUpdated
{
    use Dispatchable, SerializesModels;

    public Event $stripeEvent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->stripeEvent = $event;
    }
}
