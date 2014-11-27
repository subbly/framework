<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;

use Subbly\Model\Collection;
use Subbly\Model\Order;
use Subbly\Presenter\Presenter;

class OrderPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry
     *
     * @param \Subbly\Model\Order  $order
     *
     * @return array
     */
    public function single($order)
    {
        return $order;
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
    }
}
