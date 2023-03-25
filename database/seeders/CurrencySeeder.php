<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'Български лев',
                'symbol' => 'лв.',
                'slug' => Currency::BGN,
            ],
            [
                'name' => 'Евро',
                'symbol' => '€',
                'slug' => Currency::EUR,
            ],
            [
                'name' => 'Американски долар',
                'symbol' => '$',
                'slug' => Currency::USD,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
