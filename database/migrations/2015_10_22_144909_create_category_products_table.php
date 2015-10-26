<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('name', 250);
            $table->string('slug', 250);
            $table->text('content');
            $table->text('image');
            $table->string('code', 250)->nullable();
            $table->string('price', 250);
            $table->string('old_price', 250)->nullable();
            $table->integer('weight')->unsigned()->default(1);
            $table->boolean('is_active')->default(1);
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
        Schema::drop('products');
    }
}
