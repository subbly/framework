<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderGatewayTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
        $table->string('gateway')->after('status');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('gateway');
        });
    }
}
