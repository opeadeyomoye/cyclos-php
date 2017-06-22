<?php

namespace Cyclos\Http\Clients;

use Cyclos\Operation;
use Cyclos\Http\ClientInterface;

// @todo be sure to explicity set user agent for requests
abstract class BaseClient implements ClientInterface
{
    /**
     * @var Operation
     */
    protected $operation;

    
}
