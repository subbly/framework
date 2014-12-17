<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;

use Subbly\Subbly;

class ProductsController extends BaseController
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('@processAuthentication');

        $this->loadPresenter('Subbly\\Presenter\\V1\\ProductPresenter');
    }


    /**
     * Get Product list
     *
     * @route GET /api/v1/products
     * @authentication required
     */
    public function index()
    {
        $options = $this->getParams('offset', 'limit', 'includes', 'order_by');

        $products = Subbly::api('subbly.product')->all($options);

        return $this->jsonCollectionResponse('products', $products);
    }

    /**
     * Search one or many Product
     *
     * @route GET /api/v1/products/search/?q=
     * @authentication required
     */
    public function search()
    {
        if (!Input::has('q')) {
            return $this->jsonErrorResponse('"q" is required.');
        }

        $options = $this->getParams('offset', 'limit', 'includes', 'order_by');

        $products = Subbly::api('subbly.product')->searchBy(Input::get('q'), $options);

        return $this->jsonCollectionResponse('products', $products, array(
            'query' => Input::get('q'),
        ));
    }

    /**
     * Get Product datas
     *
     * @route GET /api/v1/products/:sku
     * @authentication required
     */
    public function show($sku)
    {
        $options = $this->getParams('includes');

        $product = Subbly::api('subbly.product')->find($sku, $options);

        return $this->jsonResponse(array(
            'product' => $this->presenter->single($product),
        ));
    }

    /**
     * Create a new Product
     *
     * @route POST /api/v1/products/
     * @authentication required
     */
    public function store()
    {
        if (!Input::has('product')) {
            return $this->jsonErrorResponse('"product" is required.');
        }

        $product = Subbly::api('subbly.product')->create( Input::get('product'), Input::get('locale', null ) );

        return $this->jsonResponse(array(
            'product' => $this->presenter->single($product),
        ),
        array(
            'status' => array(
                'code'    => 201,
                'message' => 'Product created',
            ),
        ));
    }

    /**
     * Update a Product
     *
     * @route PUT|PATCH /api/v1/products/:sku
     * @authentication required
     */
    public function update($sku)
    {
        if (!Input::has('product')) {
            return $this->jsonErrorResponse('"product" is required.');
        }

        $product = Subbly::api('subbly.product')->update($sku, Input::get('product'), Input::get('locale', null ));

        return $this->jsonResponse(array(
            'product' => $this->presenter->single($product),
        ),
        array(
            'status' => array('message' => 'Product updated'),
        ));
    }

    /**
     * Set Product order
     *
     * @route GET /api/v1/products/sort
     * @authentication required
     */
    public function sort()
    {
        if (!Input::has('products')) {
            return $this->jsonErrorResponse('"products" is required.');
        }
        
        $product = Subbly::api('subbly.product')->sort( Input::get('products') );

        return $this->jsonResponse(array(),
        array(
            'status' => array('message' => 'Product updated'),
        ));
    }
}
