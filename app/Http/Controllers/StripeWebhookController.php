<?php

namespace App\Http\Controllers;

use App\Events\Stripe\SubscriptionUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Event;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sig_header, config('stripe.webhook.secret'));
        } catch (\UnexpectedValueException $e) {
            Log::error($e->getMessage());
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error($e->getMessage());
            return response('Invalid signature', 400);
        }

        if ($event->type === Event::CUSTOMER_SUBSCRIPTION_UPDATED || $event->type === Event::CUSTOMER_SUBSCRIPTION_CREATED) {
            SubscriptionUpdated::dispatch($event);
        }

        return response('Webhook Handled', 200);
    }
}
