<?php

namespace Subbly\CMS\Controllers\Api;

use Illuminate\Support\Facades\Input;

use Subbly\Subbly;

class SettingsController extends BaseController
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
     * Get Setting list
     *
     * @route GET /api/settings
     * @authentication required
     */
    public function index()
    {
        $settings = Subbly::api('subbly.setting')->all();

        return $this->jsonResponse(array(
            'settings'  => $settings,
        ));
    }

    /**
     * Update a Setting
     *
     * @route PUT|PATCH /api/settings
     * @authentication required
     */
    public function update()
    {
        if (!Input::has('settings')) {
            return $this->jsonErrorResponse('"settings" is required.');
        }

        $user = Subbly::api('subbly.setting')->updateMany(Input::get('settings'));

        return $this->jsonResponse(array(), array(
            'status' => array(
                'code'    => 200,
                'message' => 'Settings updated',
            ),
        ));
    }
}
