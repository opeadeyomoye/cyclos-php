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
     * @return Httpful
     * 
     * @throws \Exception If request method is deemed invalid. Weird reason, huh?
     */
    public function createHttpfulRequest()
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
        return $this;
    }


    /**
     * Sets up headers for the current request.
     *
     * @return Httpful
     */
    public function setHeaders()
    {
        $headers = $this->operation->getHeaders();
        is_array($headers) || $headers = [];
        $headers = array_merge($headers, self::USER_AGENT_HEADER);

        // add authorization header
        $config = $this->operation->getConfig();

        if ($config->getAccessClient()) {
            $headers['Authorization'] = 'Bearer ' . $config->getAccessClient();
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
        $this->request->addHeaders($headers);
        $this->request->expects('json');
        return $this;
    }


    /**
     * Adds request body.
     *
     * @return Httpful
     */
    public function setBody()
    {
        // set up body. For now...
        if ($this->body) {
            $body = $this->body;
            (is_string($body) && json_decode($body)) || $body = json_encode($body);
            $this->request->body($this->body);
        }
        return $this;
    }


    /**
     * Sends our request.
     *
     * @return \Httpful\Response
     */
    protected function shoot()
    {
        return $this->request->send();
    }


    /**
     * Send the current request.
     * 
     * Models the response after a specified object, if present.
     *
     * @return \Cyclos\Response\Response
     */
    public function send()
    {
        $response = $this->createHttpfulRequest()->setHeaders()->setBody()->shoot();
        return $this->makeResponse(
            $this->expectedModel,
            $this->operation,
            $response->code,
            $response->headers->toArray(),
            $response->body
        );
    }
}
