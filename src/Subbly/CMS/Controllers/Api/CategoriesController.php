<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;
use Subbly\Subbly;

class CategoriesController extends BaseController
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('@processAuthentication');

        $this->loadPresenter('Subbly\\Presenter\\V1\\CategoryPresenter');
    }

    /**
     * Get Categories list.
     *
     * @route GET /api/v1/categories
     * @authentication required
     */
    public function index()
    {
        // $options = $this->getParams('offset', 'limit', 'includes', 'order_by');

        $categories = Subbly::api('subbly.category')->all();

        return $this->jsonResponse(array(
            'categories' => $this->presenter->collection($categories),
        ));
        // return $this->jsonCollectionResponse(array(
        //     'categories' => $this->presenter->collection($categories)
        // ));
    }

    /**
     * Get Category datas.
     *
     * @route GET /api/v1/categories/:id
     * @authentication required
     */
    public function show($id)
    {
        $options = $this->getParams('includes');

        $category = Subbly::api('subbly.category')->find($id, $options);

        return $this->jsonResponse(array(
            'category' => $this->presenter->single($category),
        ));
    }

    /**
     * Create a new Category.
     *
     * @route POST /api/v1/categories/
     * @authentication required
     */
    public function store()
    {
        if (!Input::has('category')) {
            return $this->jsonErrorResponse('"category" is required.');
        }

        $category = Subbly::api('subbly.category')->create(Input::get('category'), Input::get('locale', null));

        return $this->jsonResponse(array(
            'category' => $this->presenter->single($category),
        ),
        array(
            'status' => array(
                'code'    => 201,
                'message' => 'category created',
            ),
        ));
    }

    /**
     * Update a Category.
     *
     * @route PUT|PATCH /api/v1/categories/:sku
     * @authentication required
     */
    public function update($sku)
    {
        if (!Input::has('category')) {
            return $this->jsonErrorResponse('"category" is required.');
        }

        $category = Subbly::api('subbly.category')->update($sku, Input::get('category'), Input::get('locale', null));

        return $this->jsonResponse(array(
            'category' => $this->presenter->single($category),
        ),
        array(
            'status' => array('message' => 'category updated'),
        ));
    }

    /**
     * Set Category order.
     *
     * @route POST /api/v1/categories/sort
     * @authentication required
     */
    public function sort()
    {
        if (!Input::has('sortable')) {
            return $this->jsonErrorResponse('"sortable" is required.');
        }

        $category = Subbly::api('subbly.category')->sort(Input::get('sortable'));

        return $this->jsonResponse(array(),
        array(
            'status' => array('message' => 'category updated'),
        ));
    }

    /**
     * Delete a Category.
     *
     * @route DELETE /api/v1/categories/:id
     * @authentication required
     */
    public function destroy($id)
    {
        $category = Subbly::api('subbly.category')->delete($id);

        return $this->jsonResponse(array(),
        array(
            'status' => array(
                'code'    => 200,
                'message' => 'Category deleted',
            ),
        ));
    }
}
