<?php

namespace Cyclos;

/**
 * Finish setting up methods here
 * See that ClientInterface has everything we need here
 * Implement base client and Httpful client
 * 
 * Go on to implement APIs
 */
class Client
{

    const HTTPFUL = 'Httpful';

    /**
     * The current http client in use.
     *
     * @var \Cyclos\Http\ClientInterface
     */
    private $_httpClient;


    /**
     * Class constructor
     * 
     * Instantiates a ClientInterface for sending requests.
     *
     * @param string $client String representation of a valid http client.
     * 
     * @throws Exception If client class was not found.
     */
    public function __construct($client = null)
    {
        if (is_null($client) || !in_array($client, $this->availableClients())) {
            $client = self::HTTPFUL;
        }

        $clientClass = "\Cyclos\Http\Clients\\" . ucfirst($client);
        if (!class_exists($clientClass)) { // @todo: no check for ClientInterface implementation
            throw new \Exception("");
        }
        $this->_httpClient = new $clientClass;
    }


    /**
     * Returns an array of the currently available http clients.
     *
     * @return array
     */
    public function availableClients()
    {
        return [self::HTTPFUL];
    }


    /**
     * Add an operation description for the request.
     *
     * @param Operation $operation
     * @return $this
     */
    public function setOperation(Operation $operation)
    {
        $this->_httpClient->setOperation($operation);
        return $this;
    }


    /**
     * Set the model to expect on successful response.
     *
     * @param string $model
     * @return $this
     */
    public function expect($model)
    {
        $this->_httpClient->expect($model);
        return $this;
    }


    /**
     * Add a payload to the request.
     *
     * @param [type] $body
     * @return $this
     */
    public function withBody($body)
    {
        $this->_httpClient->withBody();
        return $this;
    }


    /**
     * Add an HTTP header to the request.
     *
     * @param string $header
     * @return $this
     */
    public function withHeader($header)
    {
        $this->_httpClient->withHeader($header);
        return $this;
    }


    /**
     * Send the request, attempt to fashion the expected response.
     *
     * @return void
     */
    public function send()
    {
        return $this->_httpClient->send();
    }

    // Alias of $this->send();
    public function now()
    {
        return $this->send();
    }
}
