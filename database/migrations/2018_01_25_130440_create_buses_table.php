<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bus_number');
            $table->string('plate_no');
            $table->string('year_manufactured');
            $table->string('bus_location')->nullable();
            $table->boolean('isFull')->default(0);
            $table->integer('route_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->text('next_stop')->nullable();
            $table->boolean('isOperating')->default(0);
            $table->timestamps('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
}
