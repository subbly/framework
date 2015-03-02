<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;
use Illuminate\Database\Eloquent\Collection;

use Subbly\Model\OrderProduct;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class OrderProductPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry
     *
     * @param \Subbly\Model\Product  $product
     *
     * @return array
     */
    public function single($product)
    {
        $entry = new Entry($product);

        $entry
            ->field('id')
            ->field('product_id')
            ->field('price')
            ->field('sale_price')
            ->field('quantity')

            ->relationshipField('product', 'Subbly\\Presenter\\V1\\ProductPresenter')

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

        foreach ($collection as $product)
        {
            $entry = new Entry($product);

            $entry
                ->field('id')
                ->field('name')
                ->field('description')
                ->field('sku')
                ->field('status')
                ->field('price')
                ->field('sale_price')
                ->field('quantity')
                
                ->value('image', $product->product->defaultImage() )
                // ->relationshipField('product', 'Subbly\\Presenter\\V1\\ProductPresenter')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
