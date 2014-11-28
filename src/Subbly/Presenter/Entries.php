<?php

namespace Subbly\Presenter;

use Illuminate\Support\Collection as ArrayCollection;

class Entries implements \IteratorAggregate
{
    /** @var ArrayCollection */
    protected $entries;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->entries = new ArrayCollection;
    }

    /**
     * Add a new Entry to the collection
     *
     * @param Entry  $entry
     *
     * @return \Subbly\Presenter\Entries
     */
    public function addEntry(Entry $entry)
    {
        $this->entries->offsetSet(null, $entry);

        return $this;
    }

    /**
     * Get the iterator.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * Get the collection as array
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();

        foreach ($this->entries as $entry) {
            array_push($array, $entry->toArray());
        }

        return $array;
    }
}
