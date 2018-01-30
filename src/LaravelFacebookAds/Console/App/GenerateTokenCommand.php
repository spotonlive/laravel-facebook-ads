<?php

namespace LaravelFacebookAds\Console\App;

use Exception;
use Illuminate\Console\Command;
use LaravelFacebookAds\Services\FacebookAdsService;

/**
 * Class GenerateTokenCommand
 * @package LaravelFacebookAds\Console\App
 */
class GenerateTokenCommand extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'facebookads:app:generate-token';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Generate a new user token';
    
    
       /**
     * @param FacebookAdsService $facebookAdsService
     */
    public function handle(FacebookAdsService $facebookAdsService)
    {
        $this->fire($facebookAdsService);
    }

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

        // Generate token
        $token = $facebookAdsService->generateAppToken($selectedAccount);

        // Error fetching the access token
        if (!$token) {
            $this->error('Something went wrong while fetching the access token');
            return false;
        }

        // Success
        $this->line(sprintf(
            'Access token: %s',
            $token
        ));
    }
}
