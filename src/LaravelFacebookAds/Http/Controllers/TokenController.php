<?php

namespace LaravelFacebookAds\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use LaravelFacebookAds\Options\ModuleOptions;
use LaravelFacebookAds\Options\OptionsInterface;

class TokenController extends BaseController
{
    /** @var ModuleOptions */
    protected $moduleOptions;

    /**
     * Construct
     *
     * @param OptionsInterface $moduleOptions
     */
    public function __construct(OptionsInterface $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * Display token
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var boolean $developerMode */
        $developerMode = $this->moduleOptions->get('developer_mode');

        if ($developerMode !== true) {
            return view('fb-token::not-in-developer-mode');
        }

        return view('fb-token::token');
    }
}
