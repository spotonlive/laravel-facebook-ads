# Usage

## Dependency injection

Inject the FacebookAdsService using dependency injection.

The service can be created using `app(LaravelFacebookAds\Services\FacebookAdsService::class)`.

```php
use LaravelFacebookAds\Services\FacebookAdsService;

class Controller
{
    /** @var FacebookAdsService */
    protected $facebookAdsService;

    public function __construct(FacebookAdsService $facebookAdsService)
    {
        $this->facebookAdsService = $facebookAdsService;
    }

    /*
     * Create an instance using the service
     */
    public function example()
    {
        $instance = $this->facebookAdsService->instance();
    }
}
```

## Facade

Create an instance using the facade

```php
FacebookAds::instance()
```

- [Go back to Generate token](02 Token.md)