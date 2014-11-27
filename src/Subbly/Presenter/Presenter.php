<?php

namespace Subbly\Presenter;

use Subbly\Model\Collection;

abstract class Presenter
{
    /** */
    protected $options;

    /**
     * The constructor.
     */
    private function __construct(array $options=array())
    {
        $this->init();
    }

    /**
     * Initialize the presenter
     */
    protected function init() {}

    /**
     * Create a new presenter instance
     *
     * @return \Subble\Presenter\Presenter
     */
    final public static function create(array $options=array())
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
