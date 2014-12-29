<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;
use Illuminate\Database\Eloquent\Collection;

use Subbly\Model\Product;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class ProductPresenter extends Presenter
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
            ->conditionalField('id', function() {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            ->field('position')
            ->field('name')
            ->field('description')
            ->field('sku')
            ->field('status')
            ->field('price')
            ->field('sale_price')
            ->field('quantity')
            ->field('locale')

            ->relationshipField('images', 'Subbly\\Presenter\\V1\\ProductImagePresenter')
            ->relationshipField('options', 'Subbly\\Presenter\\V1\\ProductOptionPresenter')
            ->relationshipField('categories', 'Subbly\\Presenter\\V1\\CategoryPresenter')

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
                ->conditionalField('id', function() {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('position')
                ->field('name')
                ->field('description')
                ->field('sku')
                ->field('status')
                ->field('price')
                ->field('sale_price')
                ->field('quantity')

                ->relationshipField('images', 'Subbly\\Presenter\\V1\\ProductImagePresenter')
                ->relationshipField('options', 'Subbly\\Presenter\\V1\\ProductOptionPresenter')
                ->relationshipField('categories', 'Subbly\\Presenter\\V1\\ProductCategoryPresenter')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
