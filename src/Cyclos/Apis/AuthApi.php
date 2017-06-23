<?php

namespace Cyclos\Apis;

use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;

class AuthApi
{
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function login($parameters = [])
    {
        /*
         | Set endpoint
         | Add default query params
         | Add default headers
         */
        // @todo Abstract creating operations?
        

        $endpoint = '/auth/session';
        $method = 'get';
        $query = http_build_query($parameters);

        return $this->getClient()
            ->setOperation($endpoint)
            ->setQuery($query)
            ->expect(['model' => 'Auth']);
    }


    public function logout()
    {
        
    }
}