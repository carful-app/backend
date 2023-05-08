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
        Schema::create('transactions_for_park_cars', function (Blueprint $table) {
            $table->foreignId('park_car_id')->constrained();
            $table->foreignId('transaction_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions_for_park_cars', function (Blueprint $table) {
            $table->dropForeign(['park_car_id', 'transaction_id']);
        });

        Schema::dropIfExists('transactions_for_park_cars');
    }
};
