<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryThreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_three', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_two_id')->unsigned();
            $table->string('name', 250);
            $table->string('slug', 250);
            $table->string('image', 250)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('category_two_id')->references('id')->on('category_two')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_three');
    }
}
