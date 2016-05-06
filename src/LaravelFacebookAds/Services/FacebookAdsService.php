<?php

namespace LaravelFacebookAds\Services;

use DateTime;
use FacebookAds\Api;
use LaravelFacebookAds\Auth\Account;
use LaravelFacebookAds\Auth\AccountInterface;
use LaravelFacebookAds\Options\OptionsInterface;
use LaravelFacebookAds\Exceptions\InvalidAccountException;
use LaravelFacebookAds\Exceptions\InvalidAccountConfigurationException;

/**
 * Class FacebookAdsService
 * @package LaravelFacebookAds\Services
 */
class FacebookAdsService implements FacebookAdsServiceInterface
{
    /** @var OptionsInterface */
    protected $moduleOptions;

    /** @var string */
    protected $scope = 'ads_management';

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
        // Select default account if no account is present
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
     * Authenticate & initiate
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
     * Get account list
     *
     * @return AccountInterface[]|array
     * @throws InvalidAccountConfigurationException
     * @throws InvalidAccountException
     */
    public function getAccountList()
    {
        $options = $this->getOptions();
        $accounts = $options->get('accounts');

        $accountList = [];

        foreach ($accounts as $name => $accountData) {
            $account = $this->getAccount($name);
            $accountList[$name] = $account;
        }

        return $accountList;
    }

    /**
     * Generate facebook user token url
     *
     * @param AccountInterface $account
     * @return string
     */
    public function generateUserTokenUrl(AccountInterface $account)
    {
        return sprintf(
            'https://www.facebook.com/dialog/oauth?client_id=%s&redirect_uri=%s&scope=%s&response_type=token',
            $account->getAppId(),
            $account->getRedirectUri() . 'fb-token',
            $this->getScope()
        );
    }

    /**
     * Generate code url
     *
     * @param string $accessToken
     * @param AccountInterface $account
     * @return string
     */
    public function generateCodeUrl($accessToken, AccountInterface $account)
    {
        return sprintf(
            'https://graph.facebook.com/oauth/client_code?access_token=%s&client_secret=%s&redirect_uri=%s&client_id=%s',
            $accessToken,
            $account->getAppSecret(),
            $account->getRedirectUri() . 'fb-token',
            $account->getAppId()
        );
    }

    /**
     * Convert token to long-lived token
     *
     * @param string $accessToken
     * @param AccountInterface $account
     * @return bool|string
     */
    public function convertTokenToLongLivedToken($accessToken, AccountInterface $account)
    {
        $response = file_get_contents(
            sprintf(
                'https://graph.facebook.com/oauth/access_token?client_id=%s&client_secret=%s&grant_type=fb_exchange_token&fb_exchange_token=%s',
                $account->getAppId(),
                $account->getAppSecret(),
                $accessToken
            )
        );

        // Match token
        preg_match('/access_token=(.*)&/', $response, $tokens);

        if (!isset($tokens[1])) {
            return false;
        }

        return $tokens[1];
    }

    /**
     * Fetch access token from code
     *
     * @param string $code
     * @param AccountInterface $account
     * @return array|bool
     */
    public function fetchAccessTokenFromCode($code, AccountInterface $account)
    {
        $jsonResponse = file_get_contents(
            sprintf(
                'https://graph.facebook.com/oauth/access_token?code=%s&client_id=%s&redirect_uri=%s',
                $code,
                $account->getAppId(),
                $account->getRedirectUri() . 'fb-token'
            )
        );

        // JSON to array
        $arrayResponse = json_decode($jsonResponse, true);

        if (!isset($arrayResponse['access_token']) || !isset($arrayResponse['expires_in'])) {
            return false;
        }

        $expireDate = new DateTime();
        $expireDate->modify(sprintf('+%s seconds', $arrayResponse['expires_in']));

        return [
            'access_token' => $arrayResponse['access_token'],
            'expires_in' => $expireDate
        ];
    }

    /**
     * Convert long-lived token to code
     *
     * @param string $longLivedAccessToken
     * @param AccountInterface $account
     * @return string
     */
    public function convertLongLivedTokenToCode($longLivedAccessToken, AccountInterface $account)
    {
        $jsonResponse = file_get_contents($this->generateCodeUrl($longLivedAccessToken, $account));

        // JSON to array
        $arrayResponse = json_decode($jsonResponse, true);

        if (!isset($arrayResponse['code'])) {
            return false;
        }

        return $arrayResponse['code'];
    }

    /**
     * Generate access token (app)
     *
     * @param AccountInterface $account
     * @return bool|string
     */
    public function generateAppToken(AccountInterface $account)
    {
        $token = file_get_contents(
            sprintf(
                'https://graph.facebook.com/oauth/access_token?client_id=%s&client_secret=%s&grant_type=client_credentials',
                $account->getAppId(),
                $account->getAppSecret()
            )
        );

        if (!substr_count($token, 'access_token=')) {
            return false;
        }

        $token = str_replace('access_token=', '', $token);

        return $token;
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

        if (
            !isset($account['appId']) ||
            !isset($account['appSecret']) ||
            !isset($account['token']) ||
            !isset($account['redirectUri'])
        ) {
            throw new InvalidAccountConfigurationException($name);
        }

        return new Account(
            $account['appId'],
            $account['appSecret'],
            $account['token'],
            $account['redirectUri']
        );
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
     * Get options
     *
     * @return OptionsInterface
     */
    protected function getOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * Get scope for user access token
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set scope for user access token
     *
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }
}
