<?php

namespace Subbly\Api\Service;

use Omnipay\Omnipay;

class PaymentService extends Service
{
    /**
     * the Gateway interface,.
     */
    private $gateway;

    /**
     * Access to the payment gateway.
     */
    public function access()
    {
        $cart = new Omnipay();

        return $cart;
    }

    /**
     * Create a new gateway.
     *
     *
     * @api
     */
    public function setProvider($provider)
    {
        return Omnipay::create($provider);
    }

    /**
     * Service name.
     */
    public function name()
    {
        return 'subbly.payment';
    }
}
