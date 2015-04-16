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
        $framework = $this->rootDirectory.'/../../vendor/laravel/framework/src';
        require $framework.'/Illuminate/Foundation/start.php';
    }

    /**
     *
     */
    protected function registerPaths()
    {
        $this->rootDirectory = __DIR__.'/../../../../tests/sandbox/';

        parent::registerPaths();

        $this->bindInstallPaths(array(
            'app'     => __DIR__.'/../../../../app/',
            'public'  => $this->rootDirectory.'/themes',
            'base'    => $this->rootDirectory,
            'storage' => $this->rootDirectory.'/storage',
        ));
    }
}
