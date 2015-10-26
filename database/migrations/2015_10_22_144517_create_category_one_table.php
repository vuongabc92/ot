<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryOneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_one', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_root_id')->unsigned();
            $table->string('name', 250);
            $table->string('slug', 250);
            $table->string('image', 250)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('category_root_id')->references('id')->on('category_root')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_one');
    }
}
