<?php

namespace App\GraphQL\Mutations\Auth;

use App\Exceptions\LoginException;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function __invoke($_, array $args): User
    {
        $guard = Auth::guard(Arr::first(config('sanctum.guard')));

        if (!$guard->attempt(Arr::only($args, ['email', 'password']))) {
            throw new LoginException(__('auth.failed'));
        }

        /**
         * Since we successfully logged in, this can no longer be `null`.
         *
         * @var \App\Models\User $user
         */
        $user = $guard->user();

        return $user;
    }
}
