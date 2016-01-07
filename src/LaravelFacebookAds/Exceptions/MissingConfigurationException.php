<?php

namespace LaravelFacebookAds\Exceptions;

class MissingConfigurationException extends Exception
{
    /**
     * Missing configuration
     *
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, \Exception $previous = null)
    {
        $message = 'Missing configuration for facebook-ads';

        parent::__construct($message, $code, $previous);
    }
}
