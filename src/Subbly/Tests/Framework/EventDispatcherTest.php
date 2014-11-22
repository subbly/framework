<?php

use Subbly\Framework\EventDispatcher;
use Subbly\Tests\Support\TestCase;

class EventDispatcherTest extends TestCase
{
    public function testConstruct()
    {
        $ed = new EventDispatcher();

        $this->assertNotNull($ed);
    }
}
