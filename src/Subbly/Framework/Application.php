<?php

namespace Subbly\Framework;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    private $rootDirectory;
    private $configDirectory;

    /**
     *
     */
    public function setConfigDirectory($configDirectory)
    {
        $this->configDirectory = $configDirectory;
    }

    /**
     *
     */
    public function setRootDirectory($rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
    }

    /**
     *
     */
    public function start()
    {
        $env = $this->detectEnvironment(array(
            'local' => array(gethostname()),
        ));

        $this->registerPaths();

        $app       = $this;
        $framework = $app['path.base'] . '/vendor/laravel/framework/src';
        require $framework . '/Illuminate/Foundation/start.php';

        $this->loadPatches();
    }

    /**
     *
     */
    protected function loadPatches()
    {
        require __DIR__.'/../../../patches/functions.php';
    }

    /**
     *
     */
    protected function registerPaths()
    {
        define('TPL_PUBLIC_PATH', $this->rootDirectory.'/themes');
        define('DS', DIRECTORY_SEPARATOR);

        $this->bindInstallPaths(array(
            'app'     => realpath(__DIR__ . '/../../../app'),
            'public'  => $this->rootDirectory . '/themes',
            'base'    => $this->rootDirectory,
            'storage' => $this->rootDirectory . '/storage',
        ));
    }
}
