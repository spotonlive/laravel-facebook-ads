<?php

namespace LaravelFacebookAds\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class TokenController extends BaseController
{
    /**
     * Display token
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('fb-token::token');
    }
}
