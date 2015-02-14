<?php

namespace Subbly\Api\Service;

use Subbly\Model\Collection;
use Subbly\Model\OrderProduct;

class OrderProductService extends Service
{
    protected $modelClass = 'Subbly\\Model\\OrderProduct';

    protected $includableRelationships = [];

    /**
     * Return an empty model
     *
     * @return \Subbly\Model\Order
     *
     * @api
     */
    public function newOrderProduct()
    {
        return new OrderProduct();
    }

    /**
     * Get all Order
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
     * Find a Order by $id
     *
     * @example
     *     $order = Subbly::api('subbly.order')->find($id);
     *
     * @param string  $id
     * @param array   $options
     *
     * @return \Subbly\Model\Order
     *
     * @api
     */
    public function find($id, array $options = array())
    {
        // $options = array_replace(array(
        //     'includes' => array('user'),
        // ), $options);

        $query = $this->newQuery($options);
        $query->where('id', '=', $id);

        return $query->firstOrFail();
    }


    /**
     * Create a new Order
     *
     * @example
     *     $order = Subbly\Model\Order;
     *     Subbly::api('subbly.order')->create($order);
     *
     *     Subbly::api('subbly.order')->create(array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
     *     ));
     *
     * @param \Subbly\Model\Order|array $order
     *
     * @return \Subbly\Model\Order
     *
     * @api
     */
    public function create($product)
    {
        if (is_array($product)) {
            $product = new OrderProduct($product);
        }

        if ($product instanceof OrderProduct)
        {
            if ($this->fireEvent('creating', array($product)) === false) return false;

            $product->setCaller($this);
            $product->save();
// dd($product);
            $this->fireEvent('created', array($product));
// dd($product);
            $product = $this->find($product->id);

            return $product;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            'Subbly\\Model\\OrderProduct',
            $this->name()
        ));
    }

    /**
     * Update a Order
     *
     * @example
     *     $order = [Subbly\Model\Order instance];
     *     Subbly::api('subbly.order')->update($order);
     *
     *     Subbly::api('subbly.order')->update($id, array(
     *         'firstname' => 'Jon',
     *         'lastname'  => 'Snow',
     *     ));
     *
     * @return \Subbly\Model\Order
     *
     * @api
     */
    public function update()
    {
        $args    = func_get_args();
        $order = null;

        if (count($args) == 1 && $args[0] instanceof Order) {
            $order = $args[0];
        }
        else if (count($args) == 2 && !empty($args[0]) && is_array($args[1]))
        {
            $order = $this->find($args[0]);
            $order->fill($args[1]);
        }

        if ($order instanceof Order)
        {
            if ($this->fireEvent('updating', array($order)) === false) return false;

            $order->setCaller($this);
            $order->save();

            $this->fireEvent('updated', array($order));

            return $order;
        }

        throw new Exception(sprintf(Exception::CANT_UPDATE_MODEL,
            'Subbly\\Model\\Order',
            $this->name()
        ));
    }

    /**
     *
     */
    public function delete()
    {
        // TODO
        // Check order status first.
        // Is an order can be deletable???
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.orderproduct';
    }
}
