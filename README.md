## This repository is under construction

[![Laravel 5.1](https://img.shields.io/badge/Laravel-5.1-orange.svg?style=flat-square)](http://laravel.com) [![Latest Stable Version](https://poser.pugx.org/nikolajlovenhardt/laravel-facebook-ads/v/stable)](https://packagist.org/packages/nikolajlovenhardt/laravel-facebook-ads) [![Total Downloads](https://poser.pugx.org/nikolajlovenhardt/laravel-facebook-ads/downloads)](https://packagist.org/packages/nikolajlovenhardt/laravel-facebook-ads) [![Latest Unstable Version](https://poser.pugx.org/nikolajlovenhardt/laravel-facebook-ads/v/unstable)](https://packagist.org/packages/nikolajlovenhardt/laravel-facebook-ads) [![License](https://poser.pugx.org/nikolajlovenhardt/laravel-facebook-ads/license)](https://packagist.org/packages/nikolajlovenhardt/laravel-facebook-ads) [![Build Status](https://travis-ci.org/nikolajlovenhardt/laravel-facebook-ads.svg?branch=master)](https://travis-ci.org/nikolajlovenhardt/laravel-facebook-ads) [![Code Climate](https://codeclimate.com/github/nikolajlovenhardt/laravel-facebook-ads/badges/gpa.svg)](https://codeclimate.com/github/nikolajlovenhardt/laravel-facebook-ads) [![Test Coverage](https://codeclimate.com/github/nikolajlovenhardt/laravel-facebook-ads/badges/coverage.svg)](https://codeclimate.com/github/nikolajlovenhardt/laravel-facebook-ads/coverage)

## Facebook Ads API for Laravel

This package is an integration of [`facebook/facebook-php-ads-sdk`](https://github.com/facebook/facebook-php-ads-sdk) in Laravel 5.*.

### Setup
- Run `$ composer require nikolajlovenhardt/laravel-facebook-ads`

- Add provider
```php
'providers' => [
    LaravelFacebookAds\LaravelFacebookAdsProvider::class,
],
```

- Run `$ php artisan vendor:publish` to publish the configuration file `config/facebook-ads.php`

### Dependencies
- [`facebook/facebook-php-ads-sdk`](https://github.com/facebook/facebook-php-ads-sdk)