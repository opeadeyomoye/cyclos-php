<?php

namespace Cyclos\Http\Clients;

use Cyclos\Operation;
use Httpful\Request;


class Httpful extends BaseClient
{
    const USER_AGENT_HEADER = ['User-Agent' => 'Httpful Cyclos PHP Client'];

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

    /**
     * Tries to create a new Httpful request object.
     *
     * @return void
     */
    public function initRequest()
    {
        $method = $this->operation->getMethod();
        
        if (!$method) {
            // throw
        }
        $method = strtolower($method);

        if (!method_exists(Request::class, $method)) {
            // throw
        }
        $this->request = Request::$method($this->operation->getUrl());
    }


    /**
     * Sets up our Httpful request object with operation data and whatnot.
     *
     * @return void
     */
    public function setupRequest()
    {
        // set up headers
        $headers = $this->operation->getHeaders();
        is_array($headers) || $headers = [];
        $headers = array_merge($headers, self::USER_AGENT_HEADER);

        $this->request->addHeaders($headers);

        // set up body. For now...
        if ($this->body) {
            $body = $this->body;
            (is_string($body) && json_decode($body)) || $body = json_encode($body);
            $this->request->body($this->body)->expects('json');
        }

    }

    public function send()
    {
        $this->initRequest();
        $this->setupRequest();
    }
}