<?php

namespace Cyclos\Http;

use Cyclos\Client as CyclosClient;

/**
 * Class ClientAwareTrait
 *
 * Provides a method to get an instance of \Cyclos\Client.
 *
 * @package Cyclos\Http
 */
trait ClientAwareTrait
{
    /**
     * Get an instance of Cyclos\Client.
     *
     * @param string $client
     * @return CyclosClient
     */
    public function getClient($client = null)
    {
        return new CyclosClient($client);
    }
}
