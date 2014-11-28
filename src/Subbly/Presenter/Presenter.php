<?php

namespace Subbly\Presenter;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Collection;

use Subbly\Subbly;

abstract class Presenter
{
    /** */
    protected static $options;

    /**
     * The constructor.
     */
    private function __construct(array $options=null)
    {
        if (is_array($options))
        {
            self::$options = array_replace(array(
                'params' => array(),
            ), $options);
        }

        $this->init();
    }

    /**
     * Initialize the presenter
     */
    protected function init() {}

    /**
     *
     */
    protected function getCurrentUser()
    {
        return Subbly::api('subbly.user')->currentUser();
    }

    /**
     * Create a new presenter instance
     *
     * @return \Subble\Presenter\Presenter
     */
    final public static function create(array $options=null)
    {
        return new static($options);
    }

    /**
     * Get formated datas for a single entry
     *
     * @param object  $model
     *
     * @return array
     */
    abstract public function single($model);

    /**
     * Get formated datas for a collection
     *
     * @param \Subbly\Model\Collection  $collection
     *
     * @return \Illuminate\Support\Collection
     */
    abstract public function collection(Collection $collection);
}
