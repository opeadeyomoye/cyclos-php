<?php

namespace Cyclos\Http\Clients;

use Cyclos\Operation;
use Httpful\Request;


class Httpful extends BaseClient
{
    /**
     * @var \Httpful\Request An Httpful request object
     */
    protected $request;


    public function __construct()
    {
        // first things first...
        if (!class_exists('Httpful\Httpful')) {
            throw new \BadMethodCallException(
                'Could not find Httpful client library. Please install it, or use another
                HTTP client interface for your requests.'
            ); // @todo replace with client-library exception?
        }
        
    }

    public function setOperation(Operation $operation)
    {
        $this->operation = $operation;
        $this->tryInitRequest();
    }

    public function tryInitRequest($force = false)
    {
        $method = $this->operation->getMethod();
        
        if (!($method) && $force) {
            // throw
        }
        $method = strtolower($method);

        if (!method_exists(Request::class, $method)) {
            // throw
        }

        $this->request = Request::$method($this->operation->getUrl());
        
    }

    public function send()
    {
        

        $method = $this->operation->getMethod();
    }
}