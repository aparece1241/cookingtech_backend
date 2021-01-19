<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->json('ingrdients');
            $table->json('procedures');
            $table->json('tag');
            $table->enum('category',['desert','soup','breakfast']);
            $table->integer('yeild');
            $table->string('video_url');
            $table->string('img_url');
            $table->unsignedBigInteger('user_id');

            //foriegn key user
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('recipes', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
}
