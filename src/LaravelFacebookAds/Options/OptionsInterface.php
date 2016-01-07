<?php

namespace LaravelFacebookAds\Options;

interface OptionsInterface
{
    public function __construct(array $options = []);

    /**
     * Get defaults
     *
     * @return array
     */
    public function getDefaults();

    /**
     * Set defaults
     * @param array $defaults
     */
    public function setDefaults(array $defaults);

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set options
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * Get value from key
     *
     * @param string $key
     * @return array|mixed|null|string
     */
    public function get($key);
}