<?php

namespace Subbly\Framework;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Subbly\Command\CreateAdminUserCommand;

class SubblyFrameworkServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->package('subbly/framework');

        include_once __DIR__.'/../../routes.php';

        // TODO
        // Container::boot();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        Artisan::add(new CreateAdminUserCommand());
    }

    private function registerMyCommand()
    {
        $this->app['create-admin-user'] = $this->app->share(function ($app) {
            return new CreateAdminUserCommand();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        $providers = array(
            'Cartalyst\\Sentry\\SentryServiceProvider',
            'Spatie\\EloquentSortable\\SortableServiceProvider',
        );

        if (Config::get('app.debug')) {
            $providers[] = 'Barryvdh\\Debugbar\\ServiceProvider';
        }

        return $providers;
    }
}
