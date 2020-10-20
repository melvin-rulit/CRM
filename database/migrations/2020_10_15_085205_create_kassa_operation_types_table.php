<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKassaOperationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kassa_operation_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('branch_id');
            $table->integer('group_id')->nullable();
            $table->boolean('coming')->nullable();
            $table->boolean('out')->nullable();
            $table->boolean('cash')->nullable();
            $table->boolean('beznal')->nullable();
            $table->text('coment')->nullable();
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
        Schema::dropIfExists('kassa_operation_types');
    }
}
