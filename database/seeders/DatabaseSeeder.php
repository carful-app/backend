<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()
            ->has(
                Car::factory()->count(3)->sequence(fn ($sequence) => [
                    'is_default' => $sequence->index === 0,
                ])
            )
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'stripe_id' => 'cus_Nm2K0rMEI8I0xh',
                'is_complete' => true,
                'balance' => 5
            ]);

        $this->call([
            ZoneSeeder::class,
            PlanSeeder::class,
        ]);

        Subscription::create([
            'plan_id' => 1,
            'user_id' => 1,
            'stripe_id' => 'sub_1N9mz9EoqrltX8fUepos21sv',
        ]);
    }
}
