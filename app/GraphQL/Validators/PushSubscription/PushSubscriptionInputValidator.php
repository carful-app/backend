<?php

namespace App\GraphQL\Validators\PushSubscription;

use Nuwave\Lighthouse\Validation\Validator;

final class PushSubscriptionInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ];
    }
}
