<?php

namespace Subbly\Api\Service;

use Subbly\Model\Collection;
use Subbly\Model\ProductImage;
use Subbly\Model\Product;

class ProductImageService extends Service
{
    protected $modelClass = 'Subbly\\Model\\ProductImage';

    protected $includableRelationships = array('product');

    /**
     * Return an empty model
     *
     * @return \Subbly\Model\ProductImage
     *
     * @api
     */
    public function newProductImage()
    {
        return new ProductImage();
    }

    /**
     * Find a ProductImage by $uid
     *
     * @example
     *     $productImage = Subbly::api('subbly.product_category')->find($uid);
     *
     * @param string  $uid
     * @param array   $options
     *
     * @return \Subbly\Model\ProductImage
     *
     * @api
     */
    public function find($uid, array $options = array())
    {
        $query = $this->newQuery($options);
        $query->where('uid', '=', $uid);

        return $query->firstOrFail();
    }

    /**
     * Find a ProductImage by Product
     *
     * @example
     *     $productImage = Subbly::api('subbly.product_category')->findByProduct($product);
     *
     * @param string|\Subbly\Model\Product  $product The Product model or the Product uid
     * @param array                         $options Some options
     *
     * @return \Subbly\Model\Collection
     *
     * @api
     */
    public function findByProduct($product, array $options = array())
    {
        if (!$product instanceof Product) {
            $product = $this->api('subbly.product')->find($product);
        }

        $query = $this->newCollectionQuery($options);
        $query->with(array('product' => function($query) use ($product) {
            $query->where('id', '=', $product->id);
        }));

        return new Collection($query);
    }

    /**
     * Create a new ProductImage
     *
     * @example
     *     $product = Subbly\Model\ProductImage;
     *     Subbly::api('subbly.product_category')->create($productImage);
     *
     *     Subbly::api('subbly.product_category')->create(array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
     *     ));
     *
     * @param \Subbly\Model\ProductImage|array  $productImage
     * @param \Subbly\Model\Product|null           $product
     *
     * @return \Subbly\Model\ProductImage
     *
     * @throws \Subbly\Api\Service\Exception
     *
     * @api
     */
    public function create($productImage, $product)
    {
        if (!$product instanceof Product) {
            $product = $this->api('subbly.product')->find($product);
        }

        if (is_array($productImage)) {
            $productImage = new ProductImage($productImage);
        }

        if ($productImage instanceof ProductImage)
        {
            if ($this->fireEvent('creating', array($productImage)) === false) return false;

            $productImage->product()->associate($product);

            $productImage->setCaller($this);
            $productImage->save();

            $this->fireEvent('created', array($productImage));

            $productImage = $this->find($productImage->uid);

            return $productImage;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            $this->modelClass,
            $this->name()
        ));
    }

    /**
     * Update a ProductImage
     *
     * @example
     *     $productImage = [Subbly\Model\ProductImage instance];
     *     Subbly::api('subbly.product_category')->update($productImage);
     *
     *     Subbly::api('subbly.product_category')->update($product_sku, array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
     *     ));
     *
     * @return \Subbly\Model\ProductImage
     *
     * @api
     */
    public function update()
    {
        $args        = func_get_args();
        $productImage = null;

        if (count($args) == 1 && $args[0] instanceof ProductImage) {
            $productImage = $args[0];
        }
        else if (count($args) == 2 && !empty($args[0]) && is_array($args[1]))
        {
            $productImage = $this->find($args[0]);
            $productImage->fill($args[1]);
        }

        if ($productImage instanceof ProductImage)
        {
            if ($this->fireEvent('updating', array($productImage)) === false) return false;

            $productImage->setCaller($this);
            $productImage->save();

            $this->fireEvent('updated', array($productImage));

            return $productImage;
        }

        throw new Exception(sprintf(Exception::CANT_UPDATE_MODEL,
            'Subbly\\Model\\ProductImage',
            $this->name()
        ));
    }

    /**
     * Delete a ProductImage
     *
     * @param \Subbly\Model\ProductImage|string  $productImage The productImage_uid or the ProductImage model
     *
     * @return \Subbly\Model\ProductImage
     *
     * @pi
     */
    public function delete($productImage)
    {
        if (!is_object($productImage)) {
            $productImage = $this->find($productImage);
        }

        if ($productImage instanceof ProductImage)
        {
            if ($this->fireEvent('deleting', array($productImage)) === false) return false;

            $productImage->delete($this);

            $this->fireEvent('deleted', array($productImage));
        }
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.product_image';
    }
}
