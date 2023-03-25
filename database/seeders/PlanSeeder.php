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
                'name' => 'Базов месечен',
                'slug' => 'basic_mountly',
                'price' => 5.00,
                'plan_type_id' => $planTypes[PlanType::MONTHLY],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Стандартен месечен',
                'slug' => 'standard_mountly',
                'price' => 10.00,
                'plan_type_id' => $planTypes[PlanType::MONTHLY],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Премиум месечен',
                'slug' => 'premium_mountly',
                'price' => 15.00,
                'plan_type_id' => $planTypes[PlanType::MONTHLY],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Базов еднократен',
                'slug' => 'basic_one_time_use',
                'price' => 5.00,
                'plan_type_id' => $planTypes[PlanType::ONE_TIME_USE],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Стандартен еднократен',
                'slug' => 'standard_one_time_use',
                'price' => 10.00,
                'plan_type_id' => $planTypes[PlanType::ONE_TIME_USE],
                'currency_id' => $currencies[Currency::BGN],
                'uses' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Премиум еднократен',
                'slug' => 'premium_one_time_use',
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
