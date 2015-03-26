<?php

use Illuminate\Database\Migrations\Migration;

class CreateGatewayTokenTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('order_tokens', function ($table) {
      $table->increments('id');
            $table->string('token');
            $table->integer('order_id');
      $table->timestamps();
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('order_tokens');
    }
}
