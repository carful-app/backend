<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\PlanService;
use App\Services\StripeService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'stripe_id',
        'is_complete',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_complete' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (!$user->stripe_id) {
                StripeService::createCustomer($user);
            }
        });
    }

    public function isSubscribed(): Attribute
    {
        return Attribute::make(
            get: function () {
                $planSlugs = PlanService::getAllPlansByType(PlanType::MONTHLY)
                    ->pluck('slug')
                    ->toArray();

                $isSubscribed = false;

                foreach ($planSlugs as $planSlug) {
                    if ($this->subscribed($planSlug)) {
                        $isSubscribed = true;
                        break;
                    }
                }

                return $isSubscribed;
            }
        );
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
