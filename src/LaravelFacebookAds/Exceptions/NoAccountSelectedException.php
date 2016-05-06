<?php

namespace LaravelFacebookAds\Exceptions;

/**
 * Class NoAccountSelectedException
 * @package LaravelFacebookAds\Exceptions
 */
class NoAccountSelectedException extends Exception
{
    /**
     * No account selected exception
     *
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($code = 0, \Exception $previous = null)
    {
        parent::__construct('No account was selected', $code, $previous);
    }
}
