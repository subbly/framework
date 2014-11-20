<?php

namespace Subbly\Core;

use Pimple;

use Subbly\Api\Api;
use Subbly\Core\EventDispatcher;

class Container extends Pimple\Container
{
    /**
     * Load services
     */
    public function load()
    {
        $c = $this;

        /**
         * Api
         */
        $this['api'] = function($c) {
            $api = new Api($c);

            $api->registerServices(array(
                'Subbly\\Api\\Service\\CartService',
                'Subbly\\Api\\Service\\OrderService',
                'Subbly\\Api\\Service\\ProductService',
                'Subbly\\Api\\Service\\ProductCategoryService',
                'Subbly\\Api\\Service\\SettingService',
                'Subbly\\Api\\Service\\UserService',
                'Subbly\\Api\\Service\\UserAddressService',
            ));

            $api->service('subbly.setting')->registerDefaultSettings(
                __DIR__ . '/../Resources/configs/default_settings.yml'
            );

            return $api;
        };

        /**
         * Event dispatcher
         */
        $this['event_dispatcher'] = function($c) {
            return new EventDispatcher();
        };

        /**
         * Swiftmailer
         */
        $this['mailer'] = function($c) {
            return ;
        };

        // Fire 'subbly.container:loaded' event
        $this['event_dispatcher']->fire('subbly.container:loaded');
    }

    /**
     * Ask if named service exists
     *
     * @param string  $name  Name of the service to check
     *
     * @return boolean
     */
    public function has($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * Get a service from is name
     *
     * @param string  $name  Name of the service to called
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this->offsetGet($name);
    }
}
