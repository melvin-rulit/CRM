<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialToBasesRable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bases', function (Blueprint $table) {
            $table->string('mother_facebook')->nullable();
            $table->string('mother_instagram')->nullable();
            $table->string('father_facebook')->nullable();
            $table->string('father_instagram')->nullable();
            $table->string('other_relative_facebook')->nullable();
            $table->string('other_relative_instagram')->nullable();
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
            $table->dropColumn(['mother_facebook', 'mother_instagram','father_facebook','father_instagram','other_relative_facebook','other_relative_instagram']);
        });
    }
}
