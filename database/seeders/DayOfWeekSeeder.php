<?php

namespace Database\Seeders;

use App\Models\DayOfWeek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DayOfWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            [
                'day' => 'Понеделник',
                'slug' => DayOfWeek::MONDAY,
            ],
            [
                'day' => 'Вторник',
                'slug' => DayOfWeek::TUESDAY,
            ],
            [
                'day' => 'Сряда',
                'slug' => DayOfWeek::WEDNESDAY,
            ],
            [
                'day' => 'Четвъртък',
                'slug' => DayOfWeek::THURSDAY,
            ],
            [
                'day' => 'Петък',
                'slug' => DayOfWeek::FRIDAY,
            ],
            [
                'day' => 'Събота',
                'slug' => DayOfWeek::SATURDAY,
            ],
            [
                'day' => 'Неделя',
                'slug' => DayOfWeek::SUNDAY,
            ],
        ];

        foreach ($days as $day) {
            DayOfWeek::create($day);
        }
    }
}
