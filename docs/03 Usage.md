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

    public function example()
    {
        $facebookInstance = $this->facebookAdsService->instance();
    }
}
```

## Facade

Access the FacebookAdsService using the facade:

```php
FacebookAds::instance()
```

- [Go back to Generate token](02 Token.md)