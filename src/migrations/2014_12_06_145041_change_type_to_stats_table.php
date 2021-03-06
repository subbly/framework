<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeToStatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn('type');
            // $table->enum('type', array('total', 'average'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('statistics', function (Blueprint $table) {
            // $table->dropColumn('type');
            $table->enum('type', array('all', 'range'));
        });
    }
}
