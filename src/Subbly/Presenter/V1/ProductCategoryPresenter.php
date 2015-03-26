<?php

namespace Subbly\Presenter\V1;

use Illuminate\Database\Eloquent\Collection;
use Subbly\Model\ProductCategory;
use Subbly\Presenter\Presenter;
use Subbly\Presenter\Entries;
use Subbly\Presenter\Entry;
use Subbly\Subbly;

class ProductCategoryPresenter extends Presenter
{
    /**
     * Get formated datas for a single entry.
     *
     * @param \Subbly\Model\ProductCategory $productCategory
     *
     * @return array
     */
    public function single($productCategory)
    {
        $entry = new Entry($productCategory);

        $entry
            ->conditionalField('id', function () {
                return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
            })

            // TODO stringField, integerField, ...
            ->field('label')
            ->field('slug')
            ->field('parent')
            ->field('position')

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

        foreach ($collection as $productCategory) {
            $entry = new Entry($productCategory);

            $entry
                ->conditionalField('id', function () {
                    return Subbly::api('subbly.user')->hasAccess('subbly.backend.auth');
                })

                ->field('label')
                ->field('slug')
                ->field('parent')
                ->field('position')

                ->dateField('created_at')
                ->dateField('updated_at')
            ;

            $entries->addEntry($entry);
        }

        return $entries->toArray();
    }
}
