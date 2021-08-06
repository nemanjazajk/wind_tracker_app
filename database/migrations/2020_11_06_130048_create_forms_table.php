<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('operater_up')->nullable();
            $table->string('operater_down')->nullable();
            $table->string('form_control')->nullable();
            $table->integer('avreging_time')->nullable();
            $table->integer('rising_wind_treshold')->nullable();
            $table->integer('falling_wind_treshold')->nullable();
            $table->integer('rising_wind_time_delay')->nullable();
            $table->integer('falling_wind_time_delay')->nullable();
            $table->integer('led_delay')->nullable();
            $table->string('leed')->nullable();
            $table->string('leed_off')->nullable();
            $table->integer('rising_interval')->nullable();
            $table->integer('lowering_interval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
