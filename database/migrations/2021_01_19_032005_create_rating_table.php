<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('stars');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('recipe_id');
            
            //foreign key
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recipe_id')->references('id')->on('recipes');

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

        Schema::dropIfExists('ratings', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('recipe_id');
        });
    }
}
