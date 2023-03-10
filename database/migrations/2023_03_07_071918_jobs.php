<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fleet_Owner_Id');
            $table->bigInteger('driver_Id');
            $table->string('title');
            $table->string('image');
            $table->string('location');
            $table->string('type_of_vehicle');
            $table->string('nature_of_job');
            $table->string('to');
            $table->string('from');
            $table->string('vehicle_brand');
            $table->string('salary');
            $table->timestamp('compeleted_date')->nullable();
            $table->timestamp('joining_date')->nullable();
            $table->smallInteger('status');
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
        Schema::dropIfExists('jobs');

    }
}
