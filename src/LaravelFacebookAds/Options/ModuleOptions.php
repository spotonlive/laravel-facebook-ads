<?php

namespace LaravelFacebookAds\Options;

class ModuleOptions extends Options
{
    /** @var array */
    protected $defaults = [
        'default' => 'default-account',

        'accounts' => [
            'default' => [
                'appId' => null,
                'secret' => null,
                'token' => null,
            ],
        ],
    ];
}