<?php

return [
    /*
     * Default facebook ad account
     */
    'default' => 'default',

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
             * App or user token
             */
            'token' => '',
        ],
    ],
];
