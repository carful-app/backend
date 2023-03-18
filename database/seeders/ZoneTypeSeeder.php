<?php

namespace Database\Seeders;

use App\Models\ZoneType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ZoneType::insert([
            [
                'name' => 'Blue', 'slug' => 'blue',
            ],
            [
                'name' => 'Green', 'slug' => 'green',
            ],
        ]);
    }
}
