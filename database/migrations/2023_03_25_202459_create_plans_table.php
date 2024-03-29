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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('uses');
            $table->foreignId('plan_type_id')->constrained();
            $table->unsignedFloat('price');
            $table->foreignId('currency_id')->constrained();
            $table->string('slug')->unique();
            $table->string('stripe_id');
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
        Schema::table('plans', function (Blueprint $table) {
            $table->dropForeign(['plan_type_id', 'currency_id']);
        });

        Schema::dropIfExists('plans');
    }
};
