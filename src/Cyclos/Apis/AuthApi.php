<?php

namespace Cyclos\Apis;

use Cyclos\Http\ClientAwareTrait;

class AuthApi
{
    use ClientAwareTrait;

    public function login($parameters = [])
    {
        $endpoint = '/auth/session';
        $method = 'get';
        $query = http_build_query($parameters);

        return $this->client
            ->setEndpoint($endpoint)
            ->setQuery($query)
            ->expect(['model' => 'Auth']);
    }


    public function logout()
    {
        
    }
}