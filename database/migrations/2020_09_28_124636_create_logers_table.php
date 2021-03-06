<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('channel')->nullable();
            $table->integer('user_id');
            $table->integer('base_id')->nullable();
            $table->string('level_name', 20);
            $table->text('message');
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
        Schema::dropIfExists('logers');
    }
}
