<?php

namespace Cyclos\Apis;

use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;
use Cyclos\Configuration\ConfigAwareTrait;

class AuthApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function login($parameters = [])
    {
        /*
         | Set endpoint
         | Add default query params
         | Add default headers
         */

        $path = '/auth/session';
        $query = [];
        $method = 'post';
        $headers = ['Content-type' => 'application/json'];

        $operation = $this->makeOperation(compact(['path', 'query', 'method', 'headers']));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()
            ->setOperation($operation)
            ->expect(['model' => 'Auth']);
    }


    public function logout()
    {
        
    }
}
