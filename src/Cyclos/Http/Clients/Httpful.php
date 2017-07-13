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
        // hmm... is this really necessary? Especially after saying "use Httpful\Httpful" ?
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

        // set up body. For now...
        if ($this->body) {
            $body = $this->body;
            (is_string($body) && json_decode($body)) || $body = json_encode($body);
            $this->request->body($this->body);
        }

        // add authorization header
        $config = $this->operation->getConfig();

        if ($config->getAccessClient()) {
            $headers['Access-Client'] = $config->getAccessClient();
        } elseif ($config->getSessionToken()) {
            $headers['Session-Token'] = $config->getSessionToken();
        } else {
            $username = $config->getUsername();
            $password = $config->getPassword();

            if (!$username || !$password) {
                throw new \Exception('Invalid or unset authorization for Cyclos request.');
            } else {
                $headers['Authorization'] = 'Basic ' . base64_encode("{$username}:{$password}");
            }
        }

        // send and model response...?
        $this->request->addHeaders($headers);
        $this->request->expects('json');
    }


    /**
     * Send the current request.
     * 
     * Models the response after a specified object, if present.
     *
     * @return mixed
     */
    public function send()
    {
        $this->initRequest();
        $this->setupRequest();

        $response = ($this->request->send());

        return $this->makeResponse(
            $this->expectedModel,
            $this->operation,
            $response->code,
            $response->headers->toArray(),
            $response->body
        );
    }
}