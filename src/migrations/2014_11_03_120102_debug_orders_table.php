<?php

use Illuminate\Database\Migrations\Migration;

class DebugOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('ALTER TABLE `orders` MODIFY `shipping_address_id` INTEGER UNSIGNED NULL;');
        DB::statement('ALTER TABLE `orders` MODIFY `billing_address_id` INTEGER UNSIGNED NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('ALTER TABLE `orders` MODIFY `shipping_address_id` INTEGER UNSIGNED NOT NULL;');
        DB::statement('ALTER TABLE `orders` MODIFY `billing_address_id` INTEGER UNSIGNED NOT NULL;');
    }
}
