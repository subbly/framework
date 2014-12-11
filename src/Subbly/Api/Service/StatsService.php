<?php

namespace Subbly\Api\Service;

use Carbon\Carbon;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

use Subbly\Api\Exception;
use Subbly\Model\Stats;

class StatsService extends Service
{
    const CACHE_NAME = 'subbly.stats';

    /** @var \Illuminate\Support\Collection $defaults */
    private $defaults = null;

    /**
     * Initialize the service.
     */
    protected function init()
    {
        $this->defaults = new Collection();
    }

    /**
     * Register a new default stats file
     *
     * @param string  $filename Name of the file
     *
     * @throws Subbly\Api\Service\Exception
     * @throws Subbly\Api\Service\Exception
     *
     * @api
     */
    public function registerDefaultStats($filename)
    {
        // TODO Just register the filename and load the content after?

        if (!file_exists($filename)) {
            throw new Exception(sprintf('File for defaults stats with filename "%s" is not found', $filename));
        }

        try {
            $yaml = Yaml::parse(file_get_contents($filename));
        }
        catch (ParseException $e) {
            throw new Exception(sprintf('Unable to parse the YAML string: %s', $e->getMessage()));
        }

        if (!isset($yaml['default_stats']) && !is_array($yaml['default_stats'])) {
            throw new Exception(sprintf('The defaults stats file "%s" must have "%s" key as root',
                $filename,
                'default_stats'
            ));
        }

        $this->defaults = new Collection(
            array_merge($this->defaults->toArray(), $yaml['default_stats'])
        );
    }

    /**
     * Set a period
     *
     * @param string  $period
     * @param array   $options $from $to
     *
     * @return Obj
     *
     * @api
     */
    private function setPeriod( $period, $options )
    {
        $format  = 'Y-m-d 00:00:00';
        $obj     = new \stdClass;
        $obj->to = Carbon::now();

        switch ( $period )
        {
            case 'lastweek':
                $obj->from = new Carbon('last week');
                break;

            case 'lastmonth':
                $obj->from = new Carbon('last month');
                break;

                // TODO
            case 'range':
                // $obj->from = new Carbon('last month');
                break;

            default:
                //TODO: get install date from generated config
                $obj->from = Carbon::createFromFormat('Y-m-d', '2014-11-11'); //Carbon::createFromDate(2014, 11, 11);
                break;
        }

        $obj->formated = $obj->from->format( $format ) . '::' . $obj->to->format( $format );

        return $obj;
    }

    /**
     * Get all Setting
     *
     * @return \Illuminate\Support\Collection
     *
     * @api
     */
    public function all()
    {
        return $this->getCachedStats();
    }


    /**
     * Find a Stats by $service/$type/$period
     *
     * @example
     *     $user = Subbly::api('subbly.stats')->find($service);
     *
     * @param string  $service
     *
     * @return Stats
     *
     * @api
     */
    public function find($service, array $options = array())
    {
        $key = $this->get( $service. '.total.lastmonth' );
dd( $key );
        $query = $this->newQuery($options);
        $query->where('uid', '=', $uid);

        return $query->firstOrFail();
    }


    /**
     * Get a Setting value
     *
     * @param string  $key  The setting key
     *
     * @return mixed
     *
     * @throws \Subbly\Api\Service\Exception
     *
     * @api
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new Exception(sprintf(Exception::STATS_KEY_NOT_EXISTS, $key));
        }

        return $this->getCachedStats()->offsetGet($key);
    }

    /**
     * Ask if a setting key exists or not
     *
     * @param string  $key  The setting key
     *
     * @return boolean
     *
     * @api
     */
    public function has($key)
    {
        return $this->defaults->offsetExists($key);
    }

    /**
     * Update many stats
     *
     * @param array  $stats Stats collection to update
     *
     * @return boolean
     *
     * @throws \Subbly\Api\Service\Exception If one setting key does not exists
     * @throws \Subbly\Api\Service\Exception If one setting value has not the good format
     *
     * @api
     */
    public function updateMany(array $stats)
    {
        // TODO Use DB::beginTransaction(), DB::rollback(), DB::commit() ?
        foreach ($stats as $k=>$v)
        {
            if ($this->update($k, $v) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Update a setting value
     *
     * @param string  $key   The setting key
     * @param mixed   $value The setting value
     *
     * @return boolean
     *
     * @throws \Subbly\Api\Service\Exception If the setting key does not exists
     * @throws \Subbly\Api\Service\Exception If the setting value has not the good format
     *
     * @api
     */
    public function update($key, $value)
    {
        if ($this->fireEvent('updating', array($key, $value)) === false) return false;

        if (!is_string($key) || !$this->has($key)) {
            throw new Exception(sprintf(Exception::STATS_KEY_NOT_EXISTS, $key));
        }

        $default = $this->defaults($key);
        if (isset($default['type']) && gettype($value) !== $default['type']) {
            throw new Exception(sprintf(Exception::STATS_VALUE_WRONG_TYPE,
                json_encode($value),
                $key,
                $default['type']
            ));
        }

        $stats = $this->getCachedStats();
        // TODO identifier = PACKAGE_NAME.KEY_NAME
        // Example subbly.shop_name

        $setting = Setting::firstOrNew(array(
            'identifier'        => $key,
            'plugin_identifier' => '',
        ));

        $setting->value = $value;

        $setting->setCaller($this);
        $setting->save();

        $stats->offsetSet($key, $value);

        $this->setCachedStats($stats);

        $this->fireEvent('updated', array($key, $value));

        return true;
    }

    /**
     * Get defaults stats
     *
     * @param string|null  $key A setting key (optional)
     *
     * @return array
     *
     * @throws \Subbly\Api\Service\Exception
     *
     * @api
     */
    public function defaults($key = null)
    {
        if (is_string($key))
        {
            if (!$this->has($key)) {
                throw new Exception(sprintf(Exception::STATS_KEY_NOT_EXISTS, $key));
            }

            return $this->defaults->offsetGet($key);
        }

        return $this->defaults->toArray();
    }

    /**
     * Refresh the stats
     *
     * @param boolean  $force Force the refresh
     *
     * @api
     */
    public function refresh($force = false)
    {
        $this->initCachedStats();
    }

    /**
     * Get the cached stats data
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCachedStats()
    {
        if (!Cache::has(self::CACHE_NAME))
        {
            $this->initCachedStats();
        }

        return new Collection(
            Cache::get(self::CACHE_NAME)
        );
    }

    /**
     * Set new stats data to cache
     *
     * @param \Illuminate\Support\Collection  $stats
     */
    private function setCachedStats(Collection $stats)
    {
        $expiresAt = Carbon::now()->addMinutes(15);
        $stats  = $stats->toArray();

        Cache::put(self::CACHE_NAME, $stats, $expiresAt);

        $this->fireEvent('cache_updated', array($stats));
    }

    /**
     *
     *
     * @return \Illuminate\Support\Collection
     */
    private function initCachedStats()
    {
        $stats = new Collection;

        // Defaults stats
        foreach ( $this->defaults as $k => $v )
        {
            $stats->offsetSet( $k, $v['value'] );
        }

        // Database stats
        foreach ( Stats::all() as $s ) 
        {
            $stats->offsetSet($s->service, $s);
        }

        $this->setCachedStats($stats);

        return $stats;
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.stats';
    }
}
