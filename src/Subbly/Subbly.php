<?php

namespace Subbly;

use Subbly\Framework\Container;

class Subbly
{
    const VERSION = '0.2.0-dev';

    /** @var Subbly\Framework\Container */
    private static $container;

    /**
     * Protection.
     */
    private function __construct()
    {
    }
    private function __clone()
    {
    }

    /**
     * Access to the Subbly Api.
     *
     * @param null|string $serviceName The name of the service (optional)
     *
     * @return \Subbly\Api\Api|\Subbly\Api\Service\Service
     *
     * @api
     */
    public static function api($serviceName = null)
    {
        $api = self::getContainer()->get('api');

        if ($serviceName !== null) {
            return $api->service($serviceName);
        }

        return $api;
    }

    /**
     * Access to the Subbly events.
     *
     * @return \Subbly\Framework\EventDispatcher
     */
    public static function events()
    {
        return self::getContainer()->get('event_dispatcher');
    }

    /**
     * Get the container.
     *
     * @return Subbly\Framework\Container
     */
    public static function getContainer()
    {
        if (!(self::$container instanceof Container)) {
            self::$container = new Container();
            self::$container->load();
        }

        return self::$container;
    }
}
