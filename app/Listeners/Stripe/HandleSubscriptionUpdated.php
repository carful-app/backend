<?php

namespace App\Listeners\Stripe;

use App\Enum\TransactionType;
use App\Events\Stripe\SubscriptionUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Stripe\Product;

class HandleSubscriptionUpdated implements ShouldQueue
{
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
     * @param  SubscriptionUpdated  $event
     * @return void
     */
    public function handle(SubscriptionUpdated $event): void
    {
        $stripeEvent = $event->stripeEvent;

        $subscription = $stripeEvent->data->object;
        $product = Product::retrieve($subscription->plan->product);

        /** @var User $user */
        $user = User::where('stripe_id', $subscription->customer)->first();

        if ($user) {
            $user->transactions()->create([
                'amount' => $product->metadata->uses,
                'type' => TransactionType::RESET,
            ]);
        }
    }
}
