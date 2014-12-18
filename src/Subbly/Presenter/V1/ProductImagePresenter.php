<?php

namespace Subbly\Presenter\V1;

use Illuminate\Support\Collection as ArrayCollection;
use Illuminate\Database\Eloquent\Collection;

use Subbly\Model\ProductImage;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class ProductImagePresenter extends Presenter
{
    /**
     * Get formated datas for a single entry
     *
     * @param \Subbly\Model\ProductImage  $productImage
     *
     * @return array
     */
    public function single($productImage)
    {
        $entry = new Entry($productImage);

        $entry
            ->conditionalField('id', function() {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            // TODO stringField, integerField, ...
            ->field('filename')
            ->field('product')
            ->field('uid')
            ->field('position')

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

        foreach ($collection as $productImage)
        {
            $entry = new Entry($productImage);

            $entry
                ->conditionalField('id', function() {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('filename')
                ->field('product')
                ->field('uid')
                ->field('position')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
