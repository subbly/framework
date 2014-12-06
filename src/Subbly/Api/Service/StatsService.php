<?php

namespace Subbly\Api\Service;

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
     * Create a new User
     *
     * @example
     *     $user = Subbly\Model\User;
     *     Subbly::api('subbly.user')->create($user);
     *
     *     Subbly::api('subbly.user')->create(array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
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
    public function create( $serviceStats, $options )
    {
        $statsObject     = ( !is_array( $serviceStats ) ) ?: new Stats( $serviceStats );
        $serviceDbObject = \DB::table( $statsObject->service );

        // default period start from now
        $to   = \Carbon\Carbon::now();

        switch ( $options['period'] )
        {
            case 'lastweek':
                $from = new \Carbon\Carbon('last week');

                $serviceDbObject->whereBetween( 'created_at', array( $from, $to ) );
                break;
            case 'lastmonth':
                $from = new \Carbon\Carbon('last month');

                $serviceDbObject->whereBetween( 'created_at', array( $from, $to ) );
                break;
            case 'lastyear':
                $from = new \Carbon\Carbon('last year');

                $serviceDbObject->whereBetween( 'created_at', array( $from, $to ) );
                break;
            case 'range':
                $serviceDbObject->whereBetween('created_at', array( $options['from'], $options['to']));
                break;
        }

echo $serviceDbObject->count();
$queries = \DB::getQueryLog();
$last_query = end($queries);
dd( $last_query );
exit();

        if ($service instanceof Stats)
        {
            if ($this->fireEvent('creating', array($service)) === false) return false;

            switch ( $service->service )
            {
                case 'customers':
                    $users = \DB::table('users');

                    switch ( $service->period )
                    {
                        case 'all':
                            $service->value = $users->count();
                            break;
                        
                        default:
                            $service->value = $users->whereBetween('created_at', array( $options['from'], $options['to']))->count();
                            break;
                    }

                    
                    break;
                
                default:
                    # code...
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
     * Delete a User
     *
     * @param User|string  $user The user_uid or the user model
     *
     * @return User
     *
     * @pi
     */
    public function delete($user)
    {
        if (!is_object($user)) {
            $user = $this->find($user);
        }

        if ($user instanceof User)
        {
            if ($this->fireEvent('deleting', array($user)) === false) return false;

            $user->delete($this);

            $this->fireEvent('deleted', array($user));
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
