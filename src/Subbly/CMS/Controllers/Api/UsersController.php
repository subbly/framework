<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;

use Subbly\Presenter\V1\UserPresenter;
use Subbly\Subbly;

class UsersController extends BaseController
{
    /**
     * The constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('@processAuthentication');

        $this->presenter = UserPresenter::create();
    }


    /**
     * Get User list
     *
     * @route GET /api/v1/users
     * @authentication required
     */
    public function index()
    {
        list($offset, $limit) = $this->apiOffsetLimit();
        $options = $this->formatOptions(array(
            'offset'   => $offset,
            'limit'    => $limit,
            'includes' => $this->includes(),
        ));

        $users = Subbly::api('subbly.user')->all($options);

        return $this->jsonCollectionResponse('users', $users);
    }

    /**
     * Search one or many User
     *
     * @route GET /api/v1/users/search/?q=
     * @authentication required
     */
    public function search()
    {
        if (!Input::has('q')) {
            return $this->jsonErrorResponse('"q" is required.');
        }

        list($offset, $limit) = $this->apiOffsetLimit();
        $options = $this->formatOptions(array(
            'offset'   => $offset,
            'limit'    => $limit,
            'includes' => $this->includes(),
        ));

        $users = Subbly::api('subbly.user')->searchBy(Input::get('q'), $options);

        return $this->jsonCollectionResponse('users', $users, array(
            'query' => Input::get('q'),
        ));
    }

    /**
     * Get User datas
     *
     * @route GET /api/v1/users/:uid
     * @authentication required
     */
    public function show($uid)
    {
        $options = $this->formatOptions(array(
            'includes' => $this->includes(),
        ));

        $user = Subbly::api('subbly.user')->find($uid, $options);

        return $this->jsonResponse(array(
            'user' => $this->presenter->single($user),
        ));
    }

    /**
     * Create a new User
     *
     * @route POST /api/v1/users/
     * @authentication required
     */
    public function store()
    {
        if (!Input::has('user')) {
            return $this->jsonErrorResponse('"user" is required.');
        }

        $user = Subbly::api('subbly.user')->create(Input::get('user'));

        return $this->jsonResponse(array(
            'user' => $this->presenter->single($user),
        ),
        array(
            'status' => array(
                'code'    => 201,
                'message' => 'User created',
            ),
        ));
    }

    /**
     * Update a User
     *
     * @route PUT|PATCH /api/v1/users/:uid
     * @authentication required
     */
    public function update($uid)
    {
        if (!Input::has('user')) {
            return $this->jsonErrorResponse('"user" is required.');
        }

        $user = Subbly::api('subbly.user')->update($uid, Input::get('user'));

        return $this->jsonResponse(array(
            'user' => $this->presenter->single($user),
        ),
        array(
            'status' => array(
                'code'    => 200,
                'message' => 'User updated',
            ),
        ));
    }
}
