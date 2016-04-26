<?php

return [
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
    'accounts' => [
        'default' => [
            'appId' => '',
            'appSecret' => '',

            /*
             * Your domain, ex. http://demo.com/ with trailing slash
             */
            'redirectUri' => 'http://spotonlive.dev/',

            /*
             * Your app- or user access token
             */
            'token' => '',
        ],
    ],
];
