<?php

namespace Subbly\Api\Service;

use Subbly\Model\Collection;
use Subbly\Model\OrderToken;

class OrderTokenService extends Service
{
    protected $modelClass = 'Subbly\\Model\\OrderToken';

    protected $includableRelationships = array('order');

    /**
     * Access to the payment gateway
     */
    public function access()
    {
        $gate = new OrderToken;

        return $gate;
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
    public function find($token, array $options = array())
    {
        $options = array_replace(array(
            'includes' => array('order'),
        ), $options);

        $query = $this->newQuery($options);
        $query->where('token', '=', $token);

        return $query->firstOrFail();
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
    public function create($orderToken)
    {
        if (is_array($orderToken)) {
            $orderToken = new OrderToken($orderToken);
        }

        if ($orderToken instanceof OrderToken)
        {
            if ($this->fireEvent('creating', array($orderToken)) === false) return false;

            $orderToken->setCaller($this);
            $orderToken->save();

            $orderToken = $this->find($orderToken->token);

            $this->fireEvent('created', array($orderToken));

            return $orderToken;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            'Subbly\\Model\\OrderToken',
            $this->name()
        ));
    }

    /**
     * Create a new gateway
     *
     * @return void
     *
     * @api
     */
    public function setProvider( $provider )
    {
        return Omnipay::create( $provider );
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.ordertoken';
    }

}
