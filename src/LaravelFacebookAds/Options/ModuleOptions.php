<?php

namespace LaravelFacebookAds\Options;

class ModuleOptions extends Options
{
    /** @var array */
    protected $defaults = [
        /*
         * Default facebook ad account
         */
        'default' => 'default',

        /*
         * Developer mode must be on in order to obtain new user access tokens
         *
         * default: false
         */
        'developer_mode' => false,

        /*
         * Facebook accounts
         */
        'accounts' => [],
    ];
}