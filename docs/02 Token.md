# Token

You'll need to generate an access token to access the facebook ads api.

## Access limits

- See https://developers.facebook.com/docs/marketing-api/access#limits

## Generate token

### User token

1. Run `$ php artisan facebookads:user:generate-token {--scope=ads_read}` from your console
2. Select the account you'd like to generate a token for
3. Copy & paste the access token into your config `config/facebook-ads.php`

### App token

1. Run `$ php artisan facebookads:app:generate-token` from your console
2. Select the account you'd like to generate a token for
3. Copy & paste the access token into your config `config/facebook-ads.php`


- [Go back to Getting started](01 Getting started.md)
- [Continue to Usage](03 Usage.md)