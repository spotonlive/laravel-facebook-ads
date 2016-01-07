<?php

namespace LaravelFacebookAds\Services;

use FacebookAds\Api;
use LaravelFacebookAds\Auth\Account;
use LaravelFacebookAds\Options\OptionsInterface;
use LaravelFacebookAds\Exceptions\InvalidAccountException;
use LaravelFacebookAds\Exceptions\InvalidAccountConfigurationException;

class FacebookAdsService implements FacebookAdsServiceInterface
{
    /** @var OptionsInterface */
    protected $moduleOptions;

    public function __construct(OptionsInterface $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * Get new Facebook API instance
     *
     * @param null $accountName
     * @return Api|null
     * @throws InvalidAccountException
     */
    public function instance($accountName = null)
    {
        /*
         * Select default account if no account is present
         */
        if (!$accountName) {
            $accountName = $this->getDefaultAccount();
        }

        $account = $this->getAccount($accountName);

        return $this->instanceWithAuth(
            $account->getAppId(),
            $account->getAppSecret(),
            $account->getToken()
        );
    }

    /**
     * Get new Facebook API instance from auth information
     *
     * @param string $appId
     * @param string $appSecret
     * @param string $token
     * @return Api|null
     */
    public function instanceWithAuth($appId, $appSecret, $token)
    {
        Api::init($appId, $appSecret, $token);

        return Api::instance();
    }

    /**
     * Get default account
     *
     * @return string
     */
    protected function getDefaultAccount()
    {
        $options = $this->getOptions();
        $account = $options->get('default');

        return $account;
    }

    /**
     * Get account from name
     *
     * @param $name
     * @return Account
     * @throws InvalidAccountConfigurationException
     * @throws InvalidAccountException
     */
    protected function getAccount($name)
    {
        $accounts = $this->getOptions()->get('accounts');

        if (!isset($accounts[$name]) || !is_array($accounts[$name])) {
            throw new InvalidAccountException($name);
        }

        $account = $accounts[$name];

        if (!isset($account['appId']) || !isset($account['appSecret']) || !isset($account['token'])) {
            throw new InvalidAccountConfigurationException($name);
        }

        return new Account(
            $account['appId'],
            $account['appSecret'],
            $account['token']
        );
    }

    /**
     * Get options
     *
     * @return OptionsInterface
     */
    protected function getOptions()
    {
        return $this->moduleOptions;
    }
}
