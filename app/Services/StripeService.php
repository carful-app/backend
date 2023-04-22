<?php

namespace App\Services;

use App\Models\User;
use Stripe\Customer;

class StripeService
{
    /**
     * Create a new Stripe customer.
     *
     * @param User $user
     * @return Customer
     */
    public static function createCustomer(User $user): Customer
    {
        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->name,
        ]);

        $user->stripe_id = $customer->id;

        return $customer;
    }
}
