<?php

namespace App\GraphQL\Mutations\Plans;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Price;
use Stripe\Subscription as StripeSubscription;

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
        $paymentMethod->attach(
            ['customer' => $user->stripe_id]
        );

        Customer::update($user->stripe_id, [
            'invoice_settings' => [
                'default_payment_method' => $paymentIntent->payment_method,
            ],
        ]);

        $price = Price::retrieve($plan->stripe_id);

        $stripeSubscription = StripeSubscription::create([
            'customer' => $user->stripe_id,
            'items' => [
                [
                    'price' => $price->id,
                ],
            ],
            'off_session' => true,
        ]);

        $subscription = new Subscription();
        $subscription->user()->associate($user);
        $subscription->plan()->associate($plan);
        $subscription->stripe_id = $stripeSubscription->id;
        $subscription->save();

        $user->is_complete = true;
        $user->save();

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
