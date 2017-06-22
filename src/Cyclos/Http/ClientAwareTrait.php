<?php

namespace Cyclos\Http;

use Cyclos\Client as CyclosClient;

/**
 * Provides a method to get an instance of namespace\ClientInterface.
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
