<?php

namespace Subbly\Presenter\V1;

use Illuminate\Database\Eloquent\Collection;
use Subbly\Model\Category;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class CategoryPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry.
     *
     * @param \Subbly\Model\Category $category
     *
     * @return array
     */
    public function single($category)
    {
        $entry = new Entry($category);

        $entry
            ->field('id')
            ->field('label')
            ->field('slug')
            ->field('parent')
            ->field('position')
        ;

        return $entry->toArray();
    }

    /**
     * Get formated datas for a collection.
     *
     * @param \Subbly\Model\Collection $collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(Collection $collection)
    {
        $entries = new Entries();

        foreach ($collection as $category) {
            $entry = new Entry($category);

            $entry
                ->field('id')
                ->field('label')
                ->field('slug')
                ->field('parent')
                ->field('position')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
