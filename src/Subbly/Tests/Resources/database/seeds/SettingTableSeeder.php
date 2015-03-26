<?php

namespace Subbly\Tests\Resources\database\seeds;

use Illuminate\Database\Seeder;
use Subbly\Subbly;

class SettingTableSeeder extends Seeder
{
    public function run()
    {
        Subbly::api('subbly.setting')->registerDefaultSettings(
            __DIR__.'/../../configs/default_settings.yml'
        );

        Subbly::api('subbly.setting')->all();
    }
}
