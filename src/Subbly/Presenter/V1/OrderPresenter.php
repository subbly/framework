<?php

namespace Subbly\Presenter\V1;

use Illuminate\Database\Eloquent\Collection;
use Subbly\Model\Order;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class OrderPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry.
     *
     * @param \Subbly\Model\Order $order
     *
     * @return array
     */
    public function single($order)
    {
        $entry = new Entry($order);

        $entry
            ->conditionalField('id', function () {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            ->field('uid')
            ->field('status')
            ->field('gateway')
            ->decimal('total_price', $order->total_price)
            ->integer('total_items', $order->total_items)
            ->decimal('shipping_cost', $order->shipping_cost)

            ->relationshipField('user', 'Subbly\\Presenter\\V1\\UserPresenter')
            ->relationshipField('billing_address', 'Subbly\\Presenter\\V1\\OrderAddressPresenter')
            ->relationshipField('shipping_address', 'Subbly\\Presenter\\V1\\OrderAddressPresenter')
            ->relationshipField('products', 'Subbly\\Presenter\\V1\\OrderProductPresenter')

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

        foreach ($collection as $order) {
            $entry = new Entry($order);

            $entry
                ->conditionalField('id', function () {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('uid')
                ->field('status')
                ->decimal('total_price', (float) $order->total_price)
                ->integer('total_items', (int) $order->total_items)
                ->decimal('shipping_cost', (float) $order->shipping_cost)

                ->relationshipField('user', 'Subbly\\Presenter\\V1\\UserPresenter')
                ->relationshipField('billing_address', 'Subbly\\Presenter\\V1\\OrderAddressPresenter')
                ->relationshipField('shipping_address', 'Subbly\\Presenter\\V1\\OrderAddressPresenter')
                ->relationshipField('products', 'Subbly\\Presenter\\V1\\OrderProductPresenter')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
