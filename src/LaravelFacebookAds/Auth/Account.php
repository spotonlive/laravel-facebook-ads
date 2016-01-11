<?php

namespace LaravelFacebookAds\Auth;

class Account
{
    /** @var string */
    protected $appId;

    /** @var string */
    protected $appSecret;

    /** @var string */
    protected $token;

    /**
     * Construct
     *
     * @param $appId
     * @param $appSecret
     * @param $token
     */
    public function __construct($appId, $appSecret, $token)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param string $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @param string $appSecret
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}
