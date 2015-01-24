<?php

namespace Subbly\Api\Service;

use Subbly\Model\Collection;
use Subbly\Model\Product;

class ProductService extends Service
{
    protected $modelClass = 'Subbly\\Model\\Product';

    protected $includableRelationships = array('images', 'options', 'categories', 'translations');

    /**
     * Return an empty model
     *
     * @return \Subbly\Model\Product
     *
     * @api
     */
    public function newProduct()
    {
        return new Product();
    }

    /**
     * Get all Product
     *
     * @param array $options
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * @api
     */
    public function all(array $options = array())
    {
        $query = $this->newCollectionQuery($options);

        return new Collection($query);
    }

    /**
     * Find a Product by $id
     *
     * @example
     *     $product = Subbly::api('subbly.product')->find('sku');
     *
     * @param string  $sku
     * @param array   $options
     *
     * @return \Subbly\Model\Product
     *
     * @api
     */
    public function find($sku, array $options = array())
    {
        $options = array_replace(array(
            'includes' => array('images', 'categories', 'options', 'translations'),
        ), $options);

        $query = $this->newQuery($options);
        $query->where('sku', '=', $sku);

        return $query->firstOrFail();
    }

    /**
     * Search a Product by options
     *
     * @example
     *     $products = Subbly::api('subbly.product')->searchBy(array(
     *         'sku'  => 'p123',
     *         'name' => 'awesome product',
     *     ));
     *     // OR
     *     $products = Subbly::api('subbly.product')->searchBy('some words');
     *
     * @param array|string  $searchQuery    Search params
     * @param array         $options        Query options
     * @param string        $statementsType Type of statement null|or|and (default is null)
     *
     * @return \Subbly\Model\Collection
     *
     * @api
     */
    public function searchBy($searchQuery, array $options = array(), $statementsType = null)
    {
        $query = $this->newSearchQuery($searchQuery, array(
            'status',
            'sku',
            'name',
            'description',
            'price',
        ), $statementsType, $options);

        return new Collection($query);
    }

    /**
     * Create a new Product
     *
     * @example
     *     $product = Subbly\Model\Product;
     *     Subbly::api('subbly.product')->create($product);
     *
     *     Subbly::api('subbly.product')->create(array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
     *     ), 'en');
     *
     * @param \Subbly\Model\Product|array $product
     *
     * @return \Subbly\Model\Product
     *
     * @api
     */
    public function create($product, $locale = null)
    {
        if (is_array($product)) {
            $product = new Product($product);
        }

        // set locale
        if( !is_null( $locale ) )
        {
            $product->setFrontLocale( $locale );
        }

        if ($product instanceof Product)
        {
            if ($this->fireEvent('creating', array($product)) === false) return false;

            $product->setCaller($this);
            $product->saveWithTranslation();

            $product = $this->find($product->sku);

            $this->fireEvent('created', array($product));

            return $product;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            'Subbly\\Model\\Product',
            $this->name()
        ));
    }

    /**
     * Update a Product
     *
     * @example
     *     $product = [Subbly\Model\Product instance];
     *     Subbly::api('subbly.product')->update($product);
     *
     *     Subbly::api('subbly.product')->update($product_sku, array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
     *     ), 'en');
     *
     * @return \Subbly\Model\Product
     *
     * @api
     */
    public function update()
    {
        $args    = func_get_args();
        $product = null;

        if (count($args) == 1 && $args[0] instanceof Product) {
            $product = $args[0];
        }
        else if (count($args) >= 2 && !empty($args[0]) && is_array($args[1]))
        {
            $product = $this->find($args[0]);

            // set locale
            if( isset( $args[2] ) && is_string( $args[2] ) )
            {
                $product->setFrontLocale( $args[2] );
            }
            
            $product->fill($args[1]);
        }

        if ($product instanceof Product)
        {
            if ($this->fireEvent('updating', array($product)) === false) return false;

            $product->setCaller($this);
            $product->saveWithTranslation();

            $this->fireEvent('updated', array($product));

            return $product;
        }

        throw new Exception(sprintf(Exception::CANT_UPDATE_MODEL,
            'Subbly\\Model\\Product',
            $this->name()
        ));
    }

    /**
     * Set the model position in the database.
     *
     * @param  array  $attributes
     * @return \Subbly\Model\Product
     */
    final public function sort(array $attributes = array())
    {
        $product        = $this->find( $attributes['movingId']  );
        $positionEntity = $this->find( $attributes['movedId'] );

        if ($product instanceof Product)
        {
            if ($this->fireEvent('sorting', array($product)) === false) return false;
            
            $product->setCaller($this);
            $product->{$attributes['type']}( $positionEntity );

            $this->fireEvent('sorted', array($product));

            return $product;
        }
        
        throw new Exception(sprintf(Exception::CANT_UPDATE_MODEL,
            'Subbly\\Model\\Product',
            $this->name()
        ));
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.product';
    }
}
