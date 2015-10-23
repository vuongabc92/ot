<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_two', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_one_id')->unsigned();
            $table->string('name', 250);
            $table->string('image', 250);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('category_one_id')->references('id')->on('category_one')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_two');
    }
}
