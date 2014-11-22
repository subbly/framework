<?php

use Subbly\Framework\Container;
use Subbly\Tests\Support\TestCase;

class ContainerTest extends TestCase
{
    public function testConstruct()
    {
        $c = new Container();

        $this->assertNotNull($c);
    }
}
