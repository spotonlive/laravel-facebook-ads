<?php

namespace LaravelFacebookAds\Services;

use FacebookAds\Api;
use LaravelFacebookAds\Auth\AccountInterface;
use LaravelFacebookAds\Options\OptionsInterface;
use LaravelFacebookAds\Exceptions\InvalidAccountException;
use LaravelFacebookAds\Exceptions\InvalidAccountConfigurationException;

/**
 * Interface FacebookAdsServiceInterface
 * @package LaravelFacebookAds\Services
 */
interface FacebookAdsServiceInterface
{
    /**
     * @param OptionsInterface $moduleOptions
     */
    public function __construct(OptionsInterface $moduleOptions);

    /**
     * Returns new Facebook Ads API instance
     *
     * @param null $accountName
     * @return Api|null
     * @throws InvalidAccountException
     */
    public function instance($accountName = null);

    /**
     * Authenticate & initiate
     *
     * @param string $appId
     * @param string $appSecret
     * @param string $token
     * @return Api|null
     */
    public function instanceWithAuth($appId, $appSecret, $token);

    /**
     * Get account list
     *
     * @return AccountInterface[]|array
     * @throws InvalidAccountConfigurationException
     * @throws InvalidAccountException
     */
    public function getAccountList();

    /**
     * Generate facebook user token url
     *
     * @param AccountInterface $account
     * @return string
     */
    public function generateUserTokenUrl(AccountInterface $account);

    /**
     * Generate code url
     *
     * @param string $accessToken
     * @param AccountInterface $account
     * @return string
     */
    public function generateCodeUrl($accessToken, AccountInterface $account);

    /**
     * Convert token to long-lived token
     *
     * @param string $accessToken
     * @param AccountInterface $account
     * @return bool|string
     */
    public function convertTokenToLongLivedToken($accessToken, AccountInterface $account);

    /**
     * Fetch access token from code
     *
     * @param string $code
     * @param AccountInterface $account
     * @return array|bool
     */
    public function fetchAccessTokenFromCode($code, AccountInterface $account);

    /**
     * Convert long-lived token to code
     *
     * @param string $longLivedAccessToken
     * @param AccountInterface $account
     * @return string
     */
    public function convertLongLivedTokenToCode($longLivedAccessToken, AccountInterface $account);

    /**
     * Get scope for user access token
     *
     * @return string
     */
    public function getScope();

    /**
     * Set scope for user access token
     *
     * @param string $scope
     */
    public function setScope($scope);
}
