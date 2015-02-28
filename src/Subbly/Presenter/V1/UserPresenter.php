<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;
use Illuminate\Database\Eloquent\Collection;

use Subbly\Model\User;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class UserPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry
     *
     * @param \Subbly\Model\User  $user
     *
     * @return array
     */
    public function single($user)
    {
        $entry = new Entry($user);

        $entry
            ->conditionalField('id', function() {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            ->field('uid')
            ->field('email')
            ->field('firstname')
            ->field('lastname')
            ->composite('displayName', 'firstname', 'lastname')

            ->relationshipField('addresses', 'Subbly\\Presenter\\V1\\UserAddressPresenter')
            ->relationshipField('orders', 'Subbly\\Presenter\\V1\\OrderPresenter')
            ->relationshipField('groups', 'Subbly\\Presenter\\V1\\GroupPresenter')

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

        foreach ($collection as $user)
        {
            $entry = new Entry($user);

            $entry
                ->conditionalField('id', function() {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('uid')
                ->field('email')
                ->field('firstname')
                ->field('lastname')
                ->composite('displayName', 'firstname', 'lastname')

                ->relationshipField('addresses', 'Subbly\\Presenter\\V1\\UserAddressPresenter')
                ->relationshipField('orders', 'Subbly\\Presenter\\V1\\OrderPresenter')
                ->relationshipField('groups', 'Subbly\\Presenter\\V1\\GroupPresenter')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
