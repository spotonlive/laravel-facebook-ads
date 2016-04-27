<?php

namespace LaravelFacebookAds;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelFacebookAds\Exceptions\MissingConfigurationException;
use LaravelFacebookAds\Http\Controllers\TokenController;
use LaravelFacebookAds\Options\ModuleOptions;
use LaravelFacebookAds\Services\FacebookAdsService;
use LaravelFacebookAds\Services\FacebookAdsServiceInterface;

class LaravelFacebookAdsProvider extends ServiceProvider
{
    /**
     * Boot
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('facebook-ads.php'),
        ]);

        $this->loadViewsFrom(
            __DIR__ . '/../../resources/views',
            'fb-token'
        );

        // Routes
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }
    }

    /**
     * Register package
     */
    public function register()
    {
        $this->mergeConfig();
        $this->registerServices();
        $this->registerControllers();
        $this->registerCommands();
    }

    /**
     * Merge config
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'facebook-ads'
        );
    }

    /**
     * Register services
     */
    protected function registerServices()
    {
        /*
         * Service: \LaravelFacebookAds\Services\FacebookAdsService
         */
        $this->app->bind(FacebookAdsService::class, function () {
            return new FacebookAdsService($this->getModuleOptions());
        });

        /*
         * Client: \LaravelFacebookAds\Clients\Facebook
         */
        $this->app->bind(Clients\Facebook::class, function (Application $app) {
            /** @var FacebookAdsServiceInterface $facebookAdsService */
            $facebookAdsService = $app->make(FacebookAdsService::class);

            return new Clients\Facebook($facebookAdsService);
        });
    }

    /**
     * Register controllers
     */
    protected function registerControllers()
    {
        /*
         * Service: \LaravelFacebookAds\Http\Controllers\TokenController
         */
        $this->app->bind(TokenController::class, function () {
            return new TokenController($this->getModuleOptions());
        });
    }

    /**
     * Get module options
     *
     * @return ModuleOptions
     * @throws MissingConfigurationException
     */
    protected function getModuleOptions()
    {
        if (!$config = config('facebook-ads')) {
            throw new MissingConfigurationException();
        }

        return new ModuleOptions($config);
    }

    /**
     * Register commands
     */
    protected function registerCommands()
    {
        $this->commands([
            Console\App\GenerateTokenCommand::class,
            Console\User\GenerateTokenCommand::class,
        ]);
    }
}