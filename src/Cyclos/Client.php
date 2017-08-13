<?php

namespace Cyclos;

use Cyclos\Configuration\Configuration;

/**
 * 
 * @todo Add isAllCool() method to quickly send and review request coolness :-)
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
            throw new \Exception(""); // @todo: uhh... the exception?
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
     * Add configuration for the current request.
     *
     * @param Configuration $config
     * @return Client
     */
    public function setConfig(Configuration $config)
    {
        $this->_httpClient->getOperation()->setConfig($config);
        return $this;
    }


    /**
     * Add an operation description for the request.
     *
     * @param Operation $operation
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return \Cyclos\Response\Response
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


    public function __call($method, $args)
    {
        if (method_exists($this->_httpClient, $method)) {
            return call_user_func_array([$this->_httpClient, $method], $args);
        }
        return false;
    }
}
