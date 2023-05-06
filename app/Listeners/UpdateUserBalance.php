<?php

namespace App\Listeners;

use App\Enum\TransactionType;
use App\Events\TransactionCreated;

class UpdateUserBalance
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
     * @param  object  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        $transaction = $event->transaction;

        $user = $transaction->user;

        switch ($transaction->type) {
            case TransactionType::RESET:
                $user->balance = $transaction->amount;
                break;

            case TransactionType::PAYMENT:
                $user->balance -= $transaction->amount;
                break;

            case TransactionType::REFUND:
            case TransactionType::ADDITIONAL_PACKAGE:
                $user->balance += $transaction->amount;
                break;
        }

        $user->save();
    }
}
