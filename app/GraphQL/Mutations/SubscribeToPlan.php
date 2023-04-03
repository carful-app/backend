<?php

namespace App\GraphQL\Mutations;

use App\Models\Plan;
use App\Models\User;

final class SubscribeToPlan
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $plan = Plan::findOrFail($args['planId']);

        /** @var User $user */
        $user = auth()->user();

        $user->newSubscription($plan->slug, $plan->stripe_id)
            ->create($args['paymentMethodId']);

        return true;
    }
}
