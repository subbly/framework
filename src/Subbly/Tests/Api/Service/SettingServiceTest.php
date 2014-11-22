<?php

use Subbly\Subbly;
use Subbly\Api\Api;
use Subbly\Api\Service\SettingService;
use Subbly\Framework\Container;
use Subbly\Tests\Support\TestCase;

class SettingServiceTest extends TestCase
{
    private function getService()
    {
        return Subbly::api('subbly.setting');
    }

    public function testConstruct()
    {
        $api = new Api(new Container(), array());
        $s   = new SettingService($api);

        $this->assertNotNull($s);
    }

    public function testAll()
    {
        $all = $this->getService()->all();

        $this->assertInstanceOf('Illuminate\\Support\\Collection', $all);
    }

    public function testGet()
    {
        $setting = $this->getService()->get('subbly.shop_name');

        $this->assertEquals('My first Subbly Shop', $setting);
    }

    public function testHas()
    {
        $hasSetting = $this->getService()->has('subbly.totaly_undefined_setting_key');
        $this->assertFalse($hasSetting);

        $hasSetting = $this->getService()->has('subbly.shop_name');
        $this->assertTrue($hasSetting);
    }

    public function testUpdate()
    {
        $tests = array(
            '-- a awesome string value --',
            1,
            20.20,
            true,
            false,
            null,
            array(1, 2, 3, 4),
        );

        foreach ($tests as $value)
        {
            $this->getService()->update('test.subbly.untyped_setting', $value);
            $this->assertSame($this->getService()->get('test.subbly.untyped_setting'), $value);
        }

        try {
            $value = array(5, 6);

            $this->getService()->update('test.subbly.string_setting', $value);
            $this->assertSame($this->getService()->get('subbly.string_setting'), $value);

            $this->fail('\Subbly\Api\Service\Exception has not be raised.');
        }
        catch (\Subbly\Api\Service\Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function testName()
    {
        $this->assertEquals($this->getService()->name(), 'subbly.setting');
    }
}
