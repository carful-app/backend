<?php

namespace Database\Seeders;

use App\Models\PlanType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planTypes = [
            [
                'name' => 'Еднократна употреба',
                'slug' => PlanType::ONE_TIME_USE,
            ],
            [
                'name' => 'Ежемесечно',
                'slug' => PlanType::MONTHLY,
            ],
        ];

        foreach ($planTypes as $planType) {
            PlanType::create($planType);
        }
    }
}
