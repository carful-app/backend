<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
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
                'stripe_id' => 'cus_NlXt84UZFMrYwl',
                'is_complete' => true
            ]);

        $this->call([
            ZoneSeeder::class,
            PlanSeeder::class,
        ]);
    }
}
