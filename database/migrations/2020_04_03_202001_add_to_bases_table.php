<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bases', function (Blueprint $table) {
            $table->string('child_surname')->nullable();
            $table->string('child_name');
            $table->string('child_middle_name')->nullable();
            $table->string('child_birthday')->nullable();
            $table->string('child_city')->nullable();
            $table->string('child_photo')->nullable();

            $table->string('mother_surname')->nullable()->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_middle_name')->nullable();
            $table->string('mother_phone');
            $table->string('mother_dop_phone')->nullable();
            $table->string('mother_activity')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_telegram')->nullable();
            $table->string('mother_viber')->nullable();

            $table->string('father_surname')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_middle_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_dop_phone')->nullable();
            $table->string('father_activity')->nullable();
            $table->string('father_email')->nullable();
            $table->string('father_telegram')->nullable();
            $table->string('father_viber')->nullable();

            $table->string('other_relative_who')->nullable();
            $table->string('other_relative_surname')->nullable();
            $table->string('other_relative_name')->nullable();
            $table->string('other_relative_middle_name')->nullable();
            $table->string('other_relative_phone')->nullable();
            $table->string('other_relative_dop_phone')->nullable();
            $table->string('other_relative_activity')->nullable();
            $table->string('other_relative_email')->nullable();
            $table->string('other_relative_telegram')->nullable();
            $table->string('other_relative_viber')->nullable();

            $table->integer('current_program')->nullable();
            $table->integer('current_branch')->nullable();
            $table->string('class_time')->nullable();
            $table->integer('lesson_hall')->nullable();
            $table->integer('source');
            $table->string('notes')->nullable();
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
