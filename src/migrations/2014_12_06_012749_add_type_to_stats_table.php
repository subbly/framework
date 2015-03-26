<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToStatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::table('statistics', function(Blueprint $table)
        // {
        // 	// $table->dropColumn('period');
        // 	$table->enum('type', array('all', 'range'));
        // 	//
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::table('statistics', function(Blueprint $table)
        // {
        // 	$table->string('period');
        // });
    }
}
