<?php

namespace Subbly\CMS\Controllers\Api;

class WelcomeController extends BaseController
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
     * Return stats for the dashboard
     *
     * @route GET /api/v1/welcome
     * @authentication required
     */
    public function index()
    {
        return $this->jsonResponse('ok');
    }
}
