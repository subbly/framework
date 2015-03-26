<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderTotalProductTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->string('total_items')->after('total_price');
        $table->decimal('shipping_cost', 10, 2)->after('total_price');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('total_price', function ($table) {
            $table->dropColumn('total_items');
            $table->dropColumn('shipping_cost');
        });
    }
}
