<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('child_surname')->nullable();
            $table->string('child_name')->nullable();
            $table->string('child_middle_name')->nullable();
            $table->string('child_birthday')->nullable();
            $table->string('parent_surname')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_middle_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_viber')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('parent_facebook')->nullable();
            $table->string('parent_instagram')->nullable();
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
            $table->dropColumn(['child_surname','child_name','child_middle_name','child_birthday','parent_surname','parent_name','parent_middle_name','parent_phone','parent_viber','parent_email','parent_facebook','parent_instagram']);
        });
    }
}
