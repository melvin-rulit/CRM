<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_halls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hall_id');
            $table->integer('programm_id');
            $table->integer('day')->nullable();
            $table->integer('time')->nullable();
            $table->integer('category_time')->nullable();
            $table->integer('total_children')->nullable();
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
        Schema::dropIfExists('schedule_halls');
    }
}
