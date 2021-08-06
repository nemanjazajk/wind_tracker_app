<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiWindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_winds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('currentWindSpeed');
            $table->string('currentState')->nullable();
            $table->string('eventError')->nullable();
            $table->string('commandResponse')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_winds');
    }
}
