<?php

namespace LaravelFacebookAds\Console\User;

use Config;
use DateTime;
use Exception;
use Illuminate\Console\Command;
use LaravelFacebookAds\Services\FacebookAdsService;
use LaravelFacebookAds\Services\FacebookAdsServiceInterface;

/**
 * Class GenerateTokenCommand
 * @package LaravelFacebookAds\Console\User
 */
class GenerateTokenCommand extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'facebookads:user:generate-token {--scope= : Access token scope}';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Generate a new app refresh token for Facebook Ads';

    /** @var FacebookAdsServiceInterface */
    protected $facebookService;

    public function __construct(FacebookAdsService $facebookAdsService)
    {
        parent::__construct();
        $this->facebookService = $facebookAdsService;
    }

    /**
     * Handle
     */
    public function handle()
    {
        $facebookAdsService = $this->facebookService;

        $accounts = $facebookAdsService->getAccountList();

        if (!count($accounts)) {
            return $this->error('Please insert some accounts in your configuration');
        }

        // Accounts

        $this->line('Accounts:');

        $accounts = $facebookAdsService->getAccountList();
        $count = 1;

        foreach ($accounts as $name => $account) {
            $this->line(sprintf(
                '%s) %s',
                $count,
                $name
            ));

            $accounts[$count] = $account;

            $count++;
        }

        // Select account
        $selectedAccount = null;

        while (!$selectedAccount) {
            $accountId = $this->ask('Please select an account');

            if (!isset($accounts[$accountId])) {
                $this->error(sprintf(
                    'Account "%s" was not found - please select an account from the list',
                    $accountId
                ));

                continue;
            }

            $selectedAccount = $accounts[$accountId];
        }

        // Check for scope
        if ($scope = $this->option('scope')) {
            if (!empty(trim($scope))) {
                $facebookAdsService->setScope($scope);
            }
        }

        // Generate token url
        $url = $facebookAdsService->generateUserTokenUrl($selectedAccount);

        $this->line('Open the following url in your browser:');
        $this->line($url);

        $accessToken = $this->ask('Insert your access token:');

        // Convert token to long-lived
        if (!$longLivedToken = $facebookAdsService->convertTokenToLongLivedToken($accessToken, $selectedAccount)) {
            $this->error('Error: The token could not be converted to a long-lived token');
            return false;
        }

        // Fetch code from token
        if (!$code = $facebookAdsService->convertLongLivedTokenToCode($longLivedToken, $selectedAccount)) {
            $this->error('Error: Could not fetch code from long-lived access token');
            return false;
        }

        // Fetch 60 days access token
        if (!$data = $facebookAdsService->fetchAccessTokenFromCode($code, $selectedAccount)) {
            $this->error('Error: Could not fetch access token from code');
            return false;
        }

        $accessToken = $data['access_token'];

        /** @var DateTime $expireDate */
        $expireDate = $data['expires_in'];

        $this->line('Insert the following access token into your config/facebook-ads.php config file:');
        $this->info($accessToken);

        if (!is_null($expireDate)) {
            $this->warn(
                sprintf(
                    'Your access token expires %s',
                    $expireDate->format('g:ia \o\n l jS F Y')
                )
            );
        }
    }
}
