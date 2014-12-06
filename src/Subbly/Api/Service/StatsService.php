<?php

namespace Subbly\Api\Service;

use Carbon\Carbon;

use Subbly\Model\Collection;
use Subbly\Model\Stats;

class StatsService extends Service
{
    protected $modelClass = 'Subbly\\Model\\Stats';

    // protected $includableRelationships = array();

    /**
     * Return an empty model
     *
     * @return \Subbly\Model\Stats
     *
     * @api
     */
    public function newStats()
    {
        return new Stats();
    }

    /**
     * Get all Stats
     *
     * @param array $options
     *
     * @return \Subbly\Model\Collection
     *
     * @api
     */
    public function all(array $options = array())
    {
        $query = $this->newCollectionQuery($options);

        return new Collection($query);
    }

    /**
     * Find a Stats by $service
     *
     * @example
     *     $user = Subbly::api('subbly.stats')->find($service, [$period]);
     *
     * @param string  $service
     * @param string  $periode
     * @param string  $period
     *
     * @return User
     *
     * @api
     */
    public function find($service, array $options = array())
    {

        $query = $this->newQuery($options);
        $query->where('service', '=', $service);

        return $query->firstOrFail();
    }

    /**
     * Create a statistics value
     *
     * @example
     *     $user = Subbly\Model\Stats;
     *     Subbly::api('subbly.stats')->create($service);
     *
     *     Subbly::api('subbly.stats')->create(array(
     *         'service' => 'users',
     *         'type'    => 'count',
     *         'period'  => 'lastweek',
     *     ));
     *
     * @param User|array $user
     *
     * @return User
     *
     * @throws \Subbly\Api\Service\Exception
     *
     * @api
     */
    public function create( $stats )
    {
        if (is_array($user)) {
            $stats = new Stats($stats);
        }

        if ($service instanceof Stats)
        {
            if ($this->fireEvent('creating', array($service)) === false) return false;
    
            $apiObj = \Subbly\Subbly::api( $stats->name );
            $to     = Carbon::now();

            switch ( $stats->period )
            {
                case 'lastweek':
                    $from = new Carbon('last week');
                    break;

                case 'lastmonth':
                    $from = new Carbon('last month');
                    break;

                    // TODO
                case 'range':
                    // $from = new Carbon('last month');
                    break;

                default:
                    //TODO: get install date from generated config
                    $from = Carbon::createFromDate(2014, 11, 11);
                    break;
            }

            switch ( $stats->type )
            {
                case 'average':
                case 'avg':
                    $this->value = $apiObj->statisticstGetAvgBetweenTwoDates( $from, $to );
                    break;
                
                default:
                    $this->value = $apiObj->statisticstGetTotalBetweenTwoDates( $from, $to );
                    break;
            }

            $service->setCaller($this);
            $service->save();

            $this->fireEvent('created', array($service));

            $service = $this->find($service->service);

            return $service;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            $this->modelClass,
            $this->name()
        ));
    }

    /**
     * Delete all Statistic service
     *
     * @param Service|string  $serice The service name or the service model
     *
     * @return Stats
     *
     * @pi
     */
    public function delete($service)
    {
        if (!is_object($service)) {
            $service = $this->find($service);
        }

        if ($service instanceof Service)
        {
            if ($this->fireEvent('deleting', array($service)) === false) return false;

            $service->delete($this);

            $this->fireEvent('deleted', array($service));
        }
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.stats';
    }
}
