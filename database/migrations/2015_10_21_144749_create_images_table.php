<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_category_id')->unsigned();
            $table->string('name', 250);
            $table->string('image', 250);
            $table->string('thumbnail', 250);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            
            $table->foreign('image_category_id')->references('id')->on('image_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
