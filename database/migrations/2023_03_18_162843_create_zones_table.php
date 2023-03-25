<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_hour');
            $table->integer('max_hour');
            $table->integer('hour_interval');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreignId('start_day_of_week_id')->constrained('day_of_weeks');
            $table->foreignId('end_day_of_week_id')->constrained('day_of_weeks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
};
