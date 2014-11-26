<?php

namespace Subbly\Presenters\V1;

use Illuminate\Support\Collection as ArrayCollection;

use Subbly\Model\Collection;
use Subbly\Model\User;
use Subbly\Presenters\Presenter;

class UserPresenter extends Presenter
{
    /**
     *
     *
     * @param \Subbly\Model\User  $user
     *
     * @return array
     */
    public function single(User $user)
    {
        return array(
            'uid'        => $user->uid,
            'email'      => $user->email,
            'firstname'  => $user->firstname,
            'lastname'   => $user->lastname,
            'addresses'  => UserAddressPresenter::get()->collection($user->addresses),
            'orders'     => OrderPresenter::get()->collection($user->orders),
            // 'groups',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        );
    }

    /**
     *
     *
     * @param \Subbly\Model\Collection  $collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(Collection $collection)
    {
        $users = new ArrayCollection;

        foreach ($collection as $user)
        {
            $users->add(array(
                'uid'        => $user->uid,
                'email'      => $user->email,
                'firstname'  => $user->firstname,
                'lastname'   => $user->lastname,
                // 'addresses'  => UserAddressPresenter::get()->collection($user->addresses),
                // 'orders'     => OrderPresenter::get()->collection($user->orders),
                // 'groups',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ));
        }

        return $users;
    }
}
