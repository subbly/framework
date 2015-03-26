<?php

namespace Subbly\Presenter\V1;

use Illuminate\Database\Eloquent\Collection;
use Subbly\Model\OrderAddress;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class OrderAddressPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry.
     *
     * @param \Subbly\Model\Order $order
     *
     * @return array
     */
    public function single($orderAddress)
    {
        $entry = new Entry($orderAddress);

        $entry
            ->field('id')
            ->field('firstname')
            ->field('lastname')
            ->field('address1')
            ->field('address2')
            ->field('zipcode')
            ->field('city')
            ->field('country')
            ->field('phone_work')
            ->field('phone_home')
            ->field('phone_mobile')
            ->field('other_informations');

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

        foreach ($collection as $order) {
            $entry = new Entry($order);

            $entry
                ->field('id')
                ->field('firstname')
                ->field('lastname')
                ->field('address1')
                ->field('address2')
                ->field('zipcode')
                ->field('city')
                ->field('country')
                ->field('phone_work')
                ->field('phone_home')
                ->field('phone_mobile')
                ->field('other_informations')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
