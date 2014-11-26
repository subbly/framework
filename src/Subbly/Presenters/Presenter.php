<?php

namespace Subbly\Presenters;

use Subbly\Model\Collection;

abstract class Presenter
{
    /**
     * The constructor.
     */
    private function __construct()
    {
    }

    /**
     *
     * @return \Subble\Presenters\Presenter
     */
    public static function create()
    {
        return new self();
    }

    /**
     *
     *
     * @param object  $model
     *
     * @return array
     */
    abstract public function single($model);

    /**
     *
     *
     * @param \Subbly\Model\Collection  $collection
     *
     * @return \Illuminate\Support\Collection
     */
    abstract public function collection(Collection $collection);
}
