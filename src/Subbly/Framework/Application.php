<?php

namespace Subbly\Framework;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    protected $rootDirectory;
    protected $configDirectory;

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

        $this->loadLaravel($env);

        $this->loadPatches();
    }

    /**
     *
     */
    protected function loadLaravel($env)
    {
        $app       = $this;
        $framework = $app['path.base'].'/vendor/laravel/framework/src';
        require $framework.'/Illuminate/Foundation/start.php';
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
        if (!defined('TPL_PUBLIC_PATH')) {
            define('TPL_PUBLIC_PATH', $this->rootDirectory.'/themes');
        }
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }

        $this->bindInstallPaths(array(
            'app'     => realpath(__DIR__.'/../../../app'),
            'public'  => $this->rootDirectory.'/themes',
            'base'    => $this->rootDirectory,
            'storage' => $this->rootDirectory.'/storage',
        ));
    }
}
