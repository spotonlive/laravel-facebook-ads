<?php

namespace LaravelFacebookAds;

use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Register package
     */
    public function register()
    {
        $this->mergeConfig();
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
}