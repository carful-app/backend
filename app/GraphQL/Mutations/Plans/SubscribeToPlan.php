<?php

namespace App\GraphQL\Mutations\Plans;

use App\Models\Plan;
use App\Models\User;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Price;

final class SubscribeToPlan
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function subscribe($_, array $args)
    {
        $plan = Plan::findOrFail($args['planId']);

        /** @var User $user */
        $user = auth()->user();

        $paymentIntent = PaymentIntent::retrieve($args['paymentIntentId']);
        $paymentMethod = PaymentMethod::retrieve($paymentIntent->payment_method);
        $paymentMethod->attach(['customer' => $user->stripe_id]);

        // todo subscribe user to plan

        return true;
    }

    public function createPaymentIntent($_, array $args)
    {
        /** @var User $user */
        $user = auth()->user();
        $plan = Plan::findOrFail($args['planId']);

        $price = Price::retrieve($plan->stripe_id);

        $paymentIntent = PaymentIntent::create([
            'amount' => $price->unit_amount,
            'currency' => $price->currency,
            'automatic_payment_methods' => [
                'enabled' => true
            ],
            'customer' => $user->stripe_id,
            'setup_future_usage' => 'off_session',
        ]);

        return $paymentIntent->client_secret;
    }
}
