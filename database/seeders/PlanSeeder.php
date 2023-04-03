<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Plan;
use App\Models\PlanType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PlanTypeSeeder::class,
            CurrencySeeder::class,
        ]);

        $planTypes = PlanType::get()->pluck('id', 'slug')->toArray();
        $currencies = Currency::get()->pluck('id', 'slug')->toArray();
        $now = Carbon::now();

        Plan::insert([
            [
                'name' => 'Базов',
                'slug' => Plan::BASIC_MONTHLY,
                'price' => 5.00,
                'plan_type_id' => $planTypes[PlanType::MONTHLY],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Стандартен',
                'slug' => Plan::STANDARD_MONTHLY,
                'price' => 10.00,
                'plan_type_id' => $planTypes[PlanType::MONTHLY],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Премиум',
                'slug' => Plan::PREMIUM_MONTHLY,
                'price' => 15.00,
                'plan_type_id' => $planTypes[PlanType::MONTHLY],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Базов',
                'slug' => Plan::BASIC_ONE_TIME_USE,
                'price' => 5.00,
                'plan_type_id' => $planTypes[PlanType::ONE_TIME_USE],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Стандартен',
                'slug' => Plan::STANDARD_ONE_TIME_USE,
                'price' => 10.00,
                'plan_type_id' => $planTypes[PlanType::ONE_TIME_USE],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Премиум',
                'slug' => Plan::PREMIUM_ONE_TIME_USE,
                'price' => 15.00,
                'plan_type_id' => $planTypes[PlanType::ONE_TIME_USE],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
