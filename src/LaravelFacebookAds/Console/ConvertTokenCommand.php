<?php

namespace LaravelFacebookAds\Console;

use Exception;
use Illuminate\Console\Command;
use LaravelFacebookAds\Services\FacebookAdsService;

class ConvertTokenCommand extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'facebookads:token:convert';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Convert access token to long-lived token';

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

        $account = null;
        $accounts = $facebookAdsService->getAccountList();

        if (!$this->option('no-interaction')) {
            $account = $this->promptAccount($accounts);
        }

        if (!$account) {
            $account = reset($accounts);
        }

        // Generate token url
        $response = $facebookAdsService->accessTokenToLongLivedToken($account);

        $this->line('Request has finished with the following response:');
        $this->line($response);
    }

    /**
     * Prompt account
     *
     * @param array $accounts
     * @return null|array
     */
    protected function promptAccount(array $accounts)
    {
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

        return $selectedAccount;
    }
}