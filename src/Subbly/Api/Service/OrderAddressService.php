<?php

namespace Subbly\Api\Service;

use Subbly\Model\OrderAddress;

class OrderAddressService extends Service
{
    protected $modelClass = 'Subbly\\Model\\OrderAddress';

    protected $includableRelationships = [];

    /**
     * Return an empty model.
     *
     * @return \Subbly\Model\OrderAddress
     *
     * @api
     */
    public function newOrderAddress()
    {
        return new OrderAddress();
    }

    /**
     * Find a Order by $id.
     *
     * @example
     *     $order = Subbly::api('subbly.order')->find($id);
     *
     * @param string $id
     * @param array  $options
     *
     * @return \Subbly\Model\Order
     *
     * @api
     */
    public function find($id, array $options = array())
    {
        $query = $this->newQuery($options);
        $query->where('id', '=', $id);

        return $query->firstOrFail();
    }

    /**
     * Create a new OrderAdress.
     *
     * @example
     *     $order = Subbly\Model\OrderAddress;
     *     Subbly::api('subbly.orderadress')->create($order, $address);
     *
     * @param \Subbly\Model\OrderAdress|array $orderAddress
     *
     * @return \Subbly\Model\OrderAddress
     *
     * @api
     */
    public function create($address)
    {
        if (is_array($address)) {
            $address = new OrderAddress($address);
        }

        if ($address instanceof OrderAddress) {
            if ($this->fireEvent('creating', array($address)) === false) {
                return false;
            }

            $address->setCaller($this);
            $address->save();

            $this->fireEvent('created', array($address));

            $address = $this->find($address->id);

            return $address;
        }

        throw new Exception(sprintf(Exception::CANT_CREATE_MODEL,
            'Subbly\\Model\\Order',
            $this->name()
        ));
    }

    /**
     * Update a Order.
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
        } elseif (count($args) == 2 && !empty($args[0]) && is_array($args[1])) {
            $order = $this->find($args[0]);
            $order->fill($args[1]);
        }

        if ($order instanceof Order) {
            if ($this->fireEvent('updating', array($order)) === false) {
                return false;
            }

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
     * Service name.
     */
    public function name()
    {
        return 'subbly.orderaddress';
    }
}
