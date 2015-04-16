<?php

namespace Subbly\Tests\Support;

use Subbly\Framework\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     *
     */
    protected function loadLaravel($env)
    {
        $app = $this;
        $framework = realpath($this->rootDirectory.'/../..').'/vendor/laravel/framework/src';
        require $framework.'/Illuminate/Foundation/start.php';
    }

    /**
     *
     */
    protected function registerPaths()
    {
        $this->rootDirectory = realpath(__DIR__.'/../../../../tests/sandbox');

        parent::registerPaths();

        $this->bindInstallPaths(array(
            'app'     => realpath(__DIR__.'/../../../../app'),
            'public'  => $this->rootDirectory.'/themes',
            'base'    => $this->rootDirectory,
            'storage' => $this->rootDirectory.'/storage',
        ));
    }
}
