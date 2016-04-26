<?php

namespace LaravelFacebookAds;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelFacebookAds\Exceptions\MissingConfigurationException;
use LaravelFacebookAds\Options\ModuleOptions;
use LaravelFacebookAds\Services\FacebookAdsService;

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

        // Register command
        $this->commands([
            Console\App\GenerateTokenCommand::class,
            Console\User\GenerateTokenCommand::class,
        ]);
    }

    /**
     * Register services
     */
    protected function registerServices()
    {
        // Facebook ads service
        $this->app->bind(FacebookAdsService::class, function (Application $app) {
            if (!$config = config('facebook-ads')) {
                throw new MissingConfigurationException();
            }

            $moduleOptions = new ModuleOptions($config);

            return new FacebookAdsService($moduleOptions);
        });
    }
}