<?php

namespace LaravelFacebookAds\Console\User;

use Exception;
use Illuminate\Console\Command;
use LaravelFacebookAds\Services\FacebookAdsService;

class GenerateTokenCommand extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'facebookads:user:generate-token';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Generate a new app refresh token for Facebook Ads';

    /**
     * Fire command
     *
     * @param FacebookAdsService $facebookAdsService
     * @return bool|void
     */
    public function fire(FacebookAdsService $facebookAdsService)
    {
        $accounts = $facebookAdsService->getAccountList();

        if (!count($accounts)) {
            return $this->error('Please insert some accounts in your configuration');
        }

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

        // Generate token url
        $url = $facebookAdsService->generateUserTokenUrl($selectedAccount);

        $this->line('Open the following url in your browser, and copy the access token into your config:');
        $this->line($url);
    }
}