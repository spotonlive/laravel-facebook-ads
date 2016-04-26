<?php

namespace LaravelFacebookAds\Exceptions;

class InvalidCallbackException extends Exception
{
    /**
     * Invalid callback
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $message = sprintf(
            'Invalid callback: %s',
            $message
        );

        parent::__construct($message, $code, $previous);
    }
}
