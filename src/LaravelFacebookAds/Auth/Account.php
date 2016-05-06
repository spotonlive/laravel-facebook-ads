<?php

namespace LaravelFacebookAds\Auth;

/**
 * Class Account
 * @package LaravelFacebookAds\Auth
 */
class Account implements AccountInterface
{
    /** @var string */
    protected $appId;

    /** @var string */
    protected $appSecret;

    /** @var string */
    protected $token;

    /** @var string */
    protected $redirectUri;

    /**
     * Construct
     *
     * @param string $appId
     * @param string $appSecret
     * @param string $token
     * @param string $redirectUri
     */
    public function __construct($appId, $appSecret, $token, $redirectUri)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->token = $token;
        $this->redirectUri = $redirectUri;
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

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }
}
