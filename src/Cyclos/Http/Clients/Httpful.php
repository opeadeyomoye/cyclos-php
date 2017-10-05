<?php

namespace Cyclos\Http\Clients;

use Cyclos\Operation;
use Httpful\Request;

/**
 * Class Httpful
 *
 * Default HTTP client using https://github.com/nategood/httpful .
 *
 * @package Cyclos\Http\Clients
 */
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
            );
        }
    }

    /**
     * Tries to create a new Httpful request object.
     *
     * @return Httpful
     * 
     * @throws \HttpRequestMethodException If request method is deemed invalid. Weird reason, huh?
     */
    public function createHttpfulRequest()
    {
        $method = strtolower((string)$this->operation->getMethod());

        if (!method_exists(Request::class, $method)) {
            throw new \HttpRequestMethodException('Invalid HTTP request method "' . $method . '" for Cyclos request.');
        }
        $this->request = Request::$method($this->operation->getUrl());
        return $this;
    }


    /**
     * Sets up headers for the current request.
     *
     * @throws \Exception If login credentials are missing.
     *
     * @return Httpful
     */
    public function setHeaders()
    {
        $headers = $this->operation->getHeaders();
        is_array($headers) || $headers = [];
        $headers = array_merge($headers, self::USER_AGENT_HEADER);

        $config = $this->operation->getConfig();

        if ($this->needsAuthorization === true) {
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
        }

        if (!array_key_exists('Accept', $headers)) {
            $this->request->expects('json');
        }
        $this->request->addHeaders($headers);
        return $this;
    }


    /**
     * Adds request body.
     *
     * @return Httpful
     */
    public function setBody()
    {
        if ($this->body) {
            $body = $this->body;
            (is_string($body) && json_decode($body)) || $body = json_encode($body);
            $this->request->body($body);
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
     * @todo(?): Model the response after a specified object, if present.
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
