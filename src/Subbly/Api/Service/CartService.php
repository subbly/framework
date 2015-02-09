<?php

namespace Subbly\Api\Service;

use Subbly\Model\Order;
use Cart;

class CartService extends Service
{
    /**
     * Access to the cart
     */
    public function access()
    {
        $order = new Order;
        // Session::get('cart.order');

        return $order;
    }

    /**
     * Add a row to the cart
     *
     * @param string|Array $id      Unique ID of the item|Item formated as array|Array of items
     * @param string       $name    Name of the item
     * @param int          $qty     Item qty to add to the cart
     * @param float        $price   Price of one item
     * @param Array        $options Array of additional options, such as 'size' or 'color'
     */
    public function add( $id, $name, $qty, $price, $options = array() )
    {
        return Cart::add( $id, $name, $qty, $price, $options );
    }

    /**
     * Update the quantity of one row of the cart
     *
     * @param  string        $rowId       The rowid of the item you want to update
     * @param  integer|Array $attribute   New quantity of the item|Array of attributes to update
     * @return boolean
     */
    public function update( $rowId, $qty )
    {
        return Cart::update( $rowId, $qty );
    }

    /**
     * Remove a row from the cart
     *
     * @param  string  $rowId The rowid of the item
     * @return boolean
     */
    public function remove( $rowId )
    {
        return Cart::remove( $rowId );
    }

    /**
     * Get a row of the cart by its ID
     *
     * @param  string $rowId The ID of the row to fetch
     * @return \Gloudemans\Shoppingcart\CartRowCollection
     */
    public function get( $rowId )
    {
        return Cart::get( $rowId );
    }

    /**
     * Empty the cart
     *
     * @return boolean
     */
    public function destroy()
    {
        return Cart::destroy();
    }

    /**
     * Get the price total
     *
     * @return float
     */
    public function total()
    {
        return Cart::total();
    }

    /**
     * Get the number of items in the cart
     *
     * @param  boolean $totalItems Get all the items (when false, will return the number of rows)
     * @return int
     */
    public function count( $totalItems = false )
    {
        return Cart::count( $totalItems );
    }

    /**
     * Get the cart content
     *
     * @return \Gloudemans\Shoppingcart\CartCollection
     *
     * @api
     */
    public function content()
    {
        return Cart::content();
    }

    /**
     * Service name
     */
    public function name()
    {
        return 'subbly.cart';
    }

}
