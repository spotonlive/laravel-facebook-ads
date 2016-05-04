<?php

namespace LaravelFacebookAds\Console\User;

use Exception;
use Illuminate\Console\Command;
use LaravelFacebookAds\Services\FacebookAdsService;
use LaravelFacebookAds\Services\FacebookAdsServiceInterface;

class GenerateTokenCommand extends Command
{
    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'facebookads:user:generate-token {--scope= : The scope}';

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

        $this->line('Open the following url in your browser, and copy the access token into your config:');
        $this->line($url);
    }
}