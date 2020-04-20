<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLprToBasesRable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bases', function (Blueprint $table) {
            $table->boolean('mother_lpr')->nullable()->default(true);
            $table->boolean('father_lpr')->nullable();
            $table->boolean('other_relative_lpr')->nullable();
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
            //
        });
    }
}
