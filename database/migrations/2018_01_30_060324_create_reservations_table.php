<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('applicant_info');
            $table->text('event_desc');
            $table->date('required_datetime');
            $table->string('vehicle_type');
            $table->integer('number_of_passenger');
            $table->string('pick_up_location');
            $table->string('drop_off_location');
            $table->string('approve_vehicle_plate_number');
            $table->string('approve_assigned_driver');
            $table->string('approve_vehicle_type');
            $table->string('approve_remarks');
            $table->string('approved_by');
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
        Schema::dropIfExists('reservations');
    }
}
