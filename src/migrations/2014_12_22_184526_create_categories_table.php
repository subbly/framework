<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::drop('product_categories');

    Schema::create('categories', function(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('parent')->unsigned()->nullable();
        $table->integer('position');

        $table->timestamps();
        $table->softDeletes();
	  });

		Schema::create('category_translations', function(Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('category_id')->unsigned();
		    $table->string('locale')->index();
        $table->string('label', 255);
        $table->string('slug', 255);
		    $table->unique(['category_id','locale']);
		    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
		});

    Schema::create('category_product', function(Blueprint $table)
    {
        $table->increments('id');
        $table->integer('category_id')->unsigned();
        $table->integer('product_id')->unsigned();

        // $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        // $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
