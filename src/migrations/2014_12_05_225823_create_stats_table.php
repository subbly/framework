<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service');
            $table->enum('type', array('total', 'average'));
            $table->string('range', 40);
            $table->enum('period', array('all', 'yesterday', 'lastweek', 'lastmonth', 'range'));
            $table->string('value');
            $table->index(array('service', 'period'));
      $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('statistics');
    }
}
