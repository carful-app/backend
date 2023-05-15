<?php

namespace App\Exceptions;

use Exception;
use GraphQL\Error\ClientAware;

class LoginException extends Exception implements ClientAware
{

    public function isClientSafe(): bool
    {
        return true;
    }
}
