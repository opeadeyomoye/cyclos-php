<?php

namespace Cyclos\Configuration;

/**
 * Class ConfigAwareTrait
 *
 * Provides methods for getting a Configuration instance.
 *
 * @package Cyclos\Configuration
 */
trait ConfigAwareTrait
{
    /**
     * Get a new instance of \Cyclos\Configuration\Configuration,
     * loading the default (demo.cyclos.org) configuration values
     * set in that class.
     *
     * @return Configuration
     *
     * @see \Cyclos\Configuration\Configuration
     */
    public function getConfig()
    {
        return Configuration::get();
    }

    /**
     * Get a clone of the configuration object that has been globalized.
     *
     * If no configuration object has been globalized, this just returns
     * a fresh instance of the configuration class.
     *
     * @return Configuration
     */
    public function getGlobalConfig()
    {
        return Configuration::getGlobalConfig();
    }
}
