<?php

namespace App\GraphQL\Mutations\PushSubscription;

final class PushSubscriptionMutation
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function pushSubscription($_, array $args)
    {
        $endpoint = $args['subscription']['endpoint'];
        $token = $args['subscription']['keys']['auth'];
        $key = $args['subscription']['keys']['p256dh'];

        /** @var User $user */
        $user = auth()->user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return true;
    }
}
