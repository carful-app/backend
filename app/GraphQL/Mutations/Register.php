<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class Register
{
    public function __invoke($_, array $args): User
    {
        $guard = Auth::guard(Arr::first(config('sanctum.guard')));

        $userCreated = User::firstOrCreate(
            [
                'email' => $args['email']
            ],
            [
                'email_verified_at' => now(),
                'name' => $args['name'],
                'password' => Hash::make($args['password']),
                'status' => true,
            ]
        );

        $guard->login($userCreated);

        return $userCreated;
    }
}