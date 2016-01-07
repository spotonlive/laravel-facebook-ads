<?php

namespace LaravelFacebookAds\Exceptions;

class InvalidAccountException extends Exception
{
    /**
     * Invalid account exception
     *
     * @param string $name
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($name, $code = 0, \Exception $previous = null)
    {
        $message = sprintf(
            'Account with name \'%s\' was not found in the configuration',
            $name
        );

        parent::__construct($message, $code, $previous);
    }
}
