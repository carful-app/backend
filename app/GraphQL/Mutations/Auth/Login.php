<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Error;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function __invoke($_, array $args): User
    {
        $guard = Auth::guard(Arr::first(config('sanctum.guard')));

        if (!$guard->attempt($args)) {
            throw new Error('Invalid credentials.');
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
