<?php

namespace LaravelFacebookAds\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelFacebookAds\Services\FacebookAdsService;

/**
 * Class FacebookAdsFacade
 * @package LaravelFacebookAds\Facades
 */
class FacebookAdsFacade extends Facade
{
    /**
     * Name of the binding container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FacebookAdsService::class;
    }
}
