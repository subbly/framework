<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampToStatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::table('statistics', function(Blueprint $table)
        // {
  //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::table('statistics', function(Blueprint $table)
        // {
  //     $table->dropColumn(array('created_at', 'updated_at'));
        // });
    }
}
