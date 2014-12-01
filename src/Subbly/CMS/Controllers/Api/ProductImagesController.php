<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;

use Subbly\Subbly;

class ProductImagesController extends BaseController
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('@processAuthentication');
    }


    /**
     * Get list of ProductImage for a Product
     *
     * @route GET /api/v1/products/:product_sku/images
     * @authentication required
     */
    public function index($product_sku)
    {
        $product = Subbly::api('subbly.product')->find($product_sku);

        $options = $this->getParams('offset', 'limit', 'includes', 'order_by');

        $productImages = Subbly::api('subbly.product_image')->findByProduct($product, $options);

        return $this->jsonCollectionResponse('product_images', $productImages);
    }

    /**
     * Create a new ProductImage
     *
     * @route POST /api/v1/products/:product_sku/images
     * @authentication required
     */
    public function store($product_sku)
    {
        $product = Subbly::api('subbly.product')->find($product_sku);

        if (!Input::has('product_image')) {
            return $this->jsonErrorResponse('"product_image" is required.');
        }

        $productImage = Subbly::api('subbly.product_image')->create(Input::get('product_image'), $product);

        return $this->jsonResponse(array(
            'product_image' => $productImage,
        ),
        array(
            'status' => array(
                'code'    => 201,
                'message' => 'ProductImage created',
            ),
        ));
    }

    /**
     * Update a ProductImage
     *
     * @route PUT|PATCH /api/v1/products/:product_sku/images/:uid
     * @authentication required
     */
    public function update($product_sku, $uid)
    {
        $product = Subbly::api('subbly.product')->find($product_sku);

        if (!Input::has('product_image')) {
            return $this->jsonErrorResponse('"product_image" is required.');
        }

        $productImage = Subbly::api('subbly.product_image')->update($uid, Input::get('product_image'));

        return $this->jsonResponse(array(
            'product_image' => $productImage,
        ),
        array(
            'status' => array(
                'code'    => 200,
                'message' => 'ProductImage updated',
            ),
        ));
    }

    /**
      * Delete a ProductImage
      *
      * @route DELETE /api/v1/products/:product_sku/images/:uid
      * @authentication required
     */
    public function delete($product_sku, $uid)
    {
        $product = Subbly::api('subbly.product')->find($product_sku);

        $productImage = Subbly::api('subbly.product_image')->delete($uid);

        return $this->jsonResponse(array(
            'product_image' => $productImage,
        ),
        array(
            'status' => array(
                'code'    => 200,
                'message' => 'ProductImage deleted',
            ),
        ));
    }
}
