# Getting started

## Installation

### Composer

Run `$ composer require nikolajlovenhardt/laravel-facebook-ads` to require the package

## Setup

Add the provider and facade in your `config/app.php` file

```php
'providers' => [
    LaravelFacebookAds\LaravelFacebookAdsProvider::class,
],
```

- Add facade
```php
'facades' => [
    'FacebookAds' => LaravelFacebookAds\Facades\FacebookAds::class,
],
```

## Configuration

Publish the configuration:

Run `$ php artisan vendor:publish` to publish the configuration file `config/facebook-ads.php`

Add your Facebook Ads accounts in the `config/facebook-ads.php`, and continue to next page to learn to generate access tokens.

- [Continue to Generate token](02 Token.md)