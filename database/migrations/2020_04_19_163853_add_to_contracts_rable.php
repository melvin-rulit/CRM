<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToContractsRable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('date')->nullable();
            $table->integer('classes_total')->nullable();
            $table->integer('classes_week')->nullable();
            $table->integer('price')->nullable();
            $table->integer('freezing_total')->nullable();
            $table->integer('freezing_kolvo')->nullable();
            $table->integer('form_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            //
        });
    }
}
