<?php

namespace LaravelFacebookAds\Services;

use LaravelFacebookAds\Options\OptionsInterface;

interface FacebookAdsServiceInterface
{
    public function __construct(OptionsInterface $moduleOptions);

    public function instance();
}
