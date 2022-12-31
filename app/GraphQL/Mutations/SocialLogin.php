<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class SocialLogin
{
    /**
     * Return a value for the field.
     *
     * @param  null  $root Always null, since this field has no parent.
     * @param  array{}  $args The field arguments passed by the client.
     * @return mixed
     */
    public function __invoke($root, array $args)
    {
        ['provider' => $provider, 'code' => $code] = $args;

        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        /** @var AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        $driver->stateless();

        $response = $driver->getAccessTokenResponse($code);

        try {
            $user = $driver->userFromToken($response['access_token']);
        } catch (ClientException $exception) {
            throw new Exception('Invalid credentials provided.');
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );
        $code = $userCreated->createToken('accessToken')->plainTextToken;

        return [
            'user' => $userCreated,
            'access_token' => $code,
        ];
    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            throw new Exception('Please login using facebook, github or google');
        }
    }
}
