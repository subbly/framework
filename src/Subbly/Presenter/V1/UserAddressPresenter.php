<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;
use Illuminate\Database\Eloquent\Collection;

use Subbly\Model\UserAddress;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class UserAddressPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry
     *
     * @param \Subbly\Model\UserAddress  $userAddress
     *
     * @return array
     */
    public function single($userAddress)
    {
        $entry = new Entry($userAddress);

        $entry
            ->conditionalField('id', function() {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            // TODO stringField, integerField, ...
            ->field('uid')
            ->field('name')
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
            ->field('others_informations')

            ->dateField('created_at')
            ->dateField('updated_at')
        ;

        return $entry->toArray();
    }

    /**
     * Get formated datas for a collection
     *
     * @param \Subbly\Model\Collection  $collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(Collection $collection)
    {
        $entries = new Entries;

        foreach ($collection as $userAddress)
        {
            $entry = new Entry($userAddress);

            $entry
                ->conditionalField('id', function() {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('uid')
                ->field('name')
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
                ->field('others_informations')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
