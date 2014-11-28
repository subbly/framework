<?php

namespace Subbly\Presenter;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as ArrayCollection;

use Subbly\Model\Collection;

class Entry
{
    /** */
    protected $model;

    /** @var ArrayCollection */
    protected $data;

    /**
     * The constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->data  = new ArrayCollection;
    }

    /**
     *
     *
     * @return \Subbly\Presenter\Entry
     */
    public function field($fieldName)
    {
        $this->addFieldData($fieldName, $this->model->getAttribute($fieldName));

        return $this;
    }

    /**
     *
     *
     * @return \Subbly\Presenter\Entry
     */
    public function conditionalField($fielName, \Closure $closure)
    {
        if ($closure() === true) {
            $this->field($fielName);
        }

        return $this;
    }

    /**
     *
     *
     * @return \Subbly\Presenter\Entry
     */
    public function relationshipField($fieldName, $presenterClassName)
    {
        if (
            in_array($fieldName, array_keys($this->model->relationsToArray()))
            && class_exists($presenterClassName)
            && is_subclass_of($presenterClassName, 'Subbly\\Presenter\\Presenter')
        ) {
            $presenter = call_user_func(array($presenterClassName, 'create'));
            $items     = $this->model->getAttribute($fieldName);
            $items     = $presenter->collection($items);

            $this->addFieldData($fieldName, $items);
        }

        return $this;
    }

    /**
     *
     *
     * @return \Subbly\Presenter\Entry
     */
    public function dateField($fieldName)
    {
        $date = $this->model->getAttribute($fieldName);
        $this->addFieldData($fieldName, $date->format(\DateTime::ISO8601));

        return $this;
    }

    /**
     *
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data->toArray();
    }

    /**
     *
     */
    protected function addFieldData($fieldName, $value)
    {
        $this->data->offsetSet($fieldName, $value);
    }
}
