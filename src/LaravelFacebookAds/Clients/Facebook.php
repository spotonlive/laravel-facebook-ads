<?php

namespace LaravelFacebookAds\Clients;

use FacebookAds\Cursor;
use FacebookAds\Object\Ad;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\AdPreview;
use FacebookAds\Object\Fields\AdPreviewFields;
use LaravelFacebookAds\Exceptions\NoAccountSelectedException;
use LaravelFacebookAds\Services\FacebookAdsServiceInterface;

/**
 * Class Facebook
 * @package LaravelFacebookAds\Client
 */
class Facebook
{
    /** @var FacebookAdsServiceInterface */
    protected $facebookAdsService;

    /** @var string|null */
    protected $accountId = null;

    /**
     * Facebook constructor.
     * @param FacebookAdsServiceInterface $facebookAdsService
     */
    public function __construct(FacebookAdsServiceInterface $facebookAdsService)
    {
        $this->facebookAdsService = $facebookAdsService;
    }

    /**
     * Set account
     *
     * @param string $id
     * @return $this
     */
    public function account($id)
    {
        $this->accountId = $id;
        return $this;
    }

    /**
     * Get ads
     * This method requires that an ad account has been set
     *
     * @param array $fields
     * @param array $params
     * @return Ad[]|array|Cursor
     * @throws \Exception
     */
    public function ads($fields = [], $params = [])
    {
        $account = $this->getAccount();

        return $account->getAds($fields, $params);
    }

    /**
     * Get campaigns
     * This method requires that an ad account has been set
     *
     * @param array $fields
     * @param array $params
     * @return Cursor|Campaign[]|array
     * @throws \Exception
     */
    public function campaigns($fields = [], $params = [])
    {
        $account = $this->getAccount();

        return $account->getCampaigns($fields, $params);
    }

    /**
     * Get ad previews
     *
     * @param Ad $ad
     * @param string $format
     * @param array $fields
     * @param array $params
     * @return Cursor|AdPreview[]|array
     */
    public function adPreviews(Ad $ad, $format, $fields = [], $params = [])
    {
        // Merge
        $params = array_merge([
            AdPreviewFields::AD_FORMAT => $format,
        ], $params);

        return $ad->getAdPreviews($fields, $params);
    }

    /**
     * Get facebook ad account
     *
     * @return AdAccount
     * @throws NoAccountSelectedException
     */
    public function getAccount()
    {
        if (is_null($this->accountId)) {
            throw new NoAccountSelectedException();
        }

        return new AdAccount($this->accountId);
    }
}
