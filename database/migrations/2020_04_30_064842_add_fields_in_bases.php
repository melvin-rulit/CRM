<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInBases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bases', function (Blueprint $table) {
            $table->integer('manager')->nullable();
            $table->integer('instructor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bases', function (Blueprint $table) {
            $table->dropColumn(['manager','instructor']);
        });
    }
}
