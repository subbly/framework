<?php

namespace Subbly\Tests\Support;

use Illuminate\Support\Facades\Artisan;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use FixturesTrait, ApplicationTrait;
    use Assertions\AssertionsTrait, Assertions\JSONAssertionsTrait;

    protected $useDatabase = true;

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {

        $sandboxDir = __DIR__.'/../../../../tests/sandbox';

        $app = new \Subbly\Framework\Application();
        $app->setRootDirectory($sandboxDir);
        $app->setConfigDirectory($sandboxDir . '/config/');
        $app->start();

        return $app;
    }

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        if ($this->useDatabase) {
            $this->setUpDb();
        }
    }

    public function teardown()
    {
        parent::teardown();

        if ($this->useDatabase) {
            $this->teardownDb();
        }
    }

    public function setUpDb()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed', array('--class' => 'Subbly\Tests\Resources\database\seeds\DatabaseSeeder'));
    }

    public function teardownDb()
    {
        // Artisan::call('migrate:reset');
    }
}
