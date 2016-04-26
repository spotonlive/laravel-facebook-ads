<?php

namespace LaravelFacebookAds\Services;

use FacebookAds\Api;
use LaravelFacebookAds\Auth\AccountInterface;
use LaravelFacebookAds\Exceptions\InvalidAccountConfigurationException;
use LaravelFacebookAds\Exceptions\InvalidAccountException;
use LaravelFacebookAds\Options\OptionsInterface;

interface FacebookAdsServiceInterface
{
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
     * Generate new app access token
     *
     * @param AccountInterface $account
     * @return bool|string
     */
    public function generateAppToken(AccountInterface $account);

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
