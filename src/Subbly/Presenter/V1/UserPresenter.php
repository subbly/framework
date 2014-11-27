<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;

use Subbly\Model\Collection;
use Subbly\Model\User;
use Subbly\Presenter\Presenter;

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
        return $user;

        return array(
            'uid'        => $user->uid,
            'email'      => $user->email,
            'firstname'  => $user->firstname,
            'lastname'   => $user->lastname,
            // 'addresses'  => UserAddressPresenter::create()->collection($user->addresses),
            // 'orders'     => OrderPresenter::create()->collection($user->orders),
            // 'groups',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        );
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
        return $collection;

        $users = new ArrayCollection;

        foreach ($collection as $user)
        {
            $users->offsetSet(null, array(
                'uid'        => $user->uid,
                'email'      => $user->email,
                'firstname'  => $user->firstname,
                'lastname'   => $user->lastname,
                // 'addresses'  => UserAddressPresenter::create()->collection($user->addresses),
                // 'orders'     => OrderPresenter::create()->collection($user->orders),
                // 'groups',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ));
        }

        return $users;
    }
}
