<?php

use Illuminate\Database\Migrations\Migration;

class RemoveUserAddressesUidUnique extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_addresses', function ($table) {
          $table->dropUnique('user_addresses_uid_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
