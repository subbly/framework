<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product_images', function (Blueprint $table) {
        $table->integer('position');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::drop('products');
    }
}
