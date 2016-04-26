<?php

namespace LaravelFacebookAds\Auth;

interface AccountInterface
{
    /**
     * Construct
     *
     * @param string $appId
     * @param string $appSecret
     * @param string $token
     * @param string $redirectUri
     */
    public function __construct($appId, $appSecret, $token, $redirectUri);

    /**
     * @return string
     */
    public function getAppId();

    /**
     * @param string $appId
     */
    public function setAppId($appId);

    /**
     * @return string
     */
    public function getAppSecret();

    /**
     * @param string $appSecret
     */
    public function setAppSecret($appSecret);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param string $token
     */
    public function setToken($token);

    /**
     * @return string
     */
    public function getRedirectUri();

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri);
}
