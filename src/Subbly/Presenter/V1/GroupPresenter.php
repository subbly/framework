<?php

namespace Subbly\Presenter\V1;

use Illuminate\Database\Eloquent\Collection;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class GroupPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry.
     *
     * @param object $group
     *
     * @return array
     */
    public function single($group)
    {
        $entry = new Entry($group);

        $entry
            ->conditionalField('id', function () {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            ->field('name')
            ->field('permissions')

            ->dateField('created_at')
            ->dateField('updated_at')
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

        foreach ($collection as $group) {
            $entry = new Entry($group);

            $entry
                ->conditionalField('id', function () {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('name')
                ->field('permissions')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
