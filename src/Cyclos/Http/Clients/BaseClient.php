<?php

namespace Cyclos\Http\Clients;

use Cyclos\Operation;
use Cyclos\Http\ClientInterface;

abstract class BaseClient implements ClientInterface
{
    public function parseOperation(Operation $operation)
    {
        $this->withHeader($operation->getContentTypeHeader());
    }
}
// be sure to explicity set user agent for requests
