<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;

use Subbly\Subbly;

class UserAddressesController extends BaseController
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
     * Get list of UserAddress for a User
     *
     * @route GET /api/v1/users/:user_uid/addresses
     * @authentication required
     */
    public function index($user_uid)
    {
        $user = Subbly::api('subbly.user')->find($user_uid);

        $options = $this->getParams('offset', 'limit', 'includes', 'order_by');

        $userAddresses = Subbly::api('subbly.user_address')->findByUser($user, $options);

        return $this->jsonCollectionResponse('user_addresses', $userAddresses);
    }

    /**
     * Create a new UserAddress
     *
     * @route POST /api/v1/users/:user_uid/addresses
     * @authentication required
     */
    public function store($user_uid)
    {
        $user = Subbly::api('subbly.user')->find($user_uid);

        if (!Input::has('user_address')) {
            return $this->jsonErrorResponse('"user_address" is required.');
        }

        $userAddress = Subbly::api('subbly.user_address')->create(Input::get('user_address'), $user);

        return $this->jsonResponse(array(
            'user_address' => $userAddress,
        ),
        array(
            'status' => array(
                'code'    => 201,
                'message' => 'UserAddress created',
            ),
        ));
    }

    /**
     * Update a UserAddress
     *
     * @route PUT|PATCH /api/v1/users/:user_uid/addresses/:uid
     * @authentication required
     */
    public function update($user_uid, $uid)
    {
        $user = Subbly::api('subbly.user')->find($user_uid);

        if (!Input::has('user_address')) {
            return $this->jsonErrorResponse('"user_address" is required.');
        }

        $userAddress = Subbly::api('subbly.user_address')->update($uid, Input::get('user_address'));

        return $this->jsonResponse(array(
            'user_address' => $userAddress,
        ),
        array(
            'status' => array(
                'code'    => 200,
                'message' => 'UserAddress updated',
            ),
        ));
    }

    /**
      * Delete a UserAddress
      *
      * @route DELETE /api/v1/users/:user_uid/addresses/:uid
      * @authentication required
     */
    public function delete($user_uid, $uid)
    {
        $user = Subbly::api('subbly.user')->find($user_uid);

        $userAddress = Subbly::api('subbly.user_address')->delete($uid);

        return $this->jsonResponse(array(
            'user_address' => $userAddress,
        ),
        array(
            'status' => array(
                'code'    => 200,
                'message' => 'UserAddress deleted',
            ),
        ));
    }
}
