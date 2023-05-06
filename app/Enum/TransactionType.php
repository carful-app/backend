<?php

namespace App\Enum;

enum TransactionType: string
{
    case RESET = 'reset';
    case PAYMENT = 'payment';
    case REFUND = 'refund';
    case ADDITIONAL_PACKAGE = 'additionalPackage';
}
