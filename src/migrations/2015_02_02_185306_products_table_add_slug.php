<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsTableAddSlug extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product_translations', function (Blueprint $table) {
        $table->string('slug')->after('name');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('product_translations', function (Blueprint $table) {
        $table->dropColumn('slug');
    });
    }
}
