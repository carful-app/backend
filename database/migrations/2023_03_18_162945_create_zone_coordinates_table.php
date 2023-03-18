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
        Schema::create('zone_coordinates', function (Blueprint $table) {
            $table->id();
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('zone_id')->constrained();
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
        Schema::table('zone_coordinates', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
        });

        Schema::dropIfExists('zone_coordinates');
    }
};
