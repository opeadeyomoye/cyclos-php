<?php

namespace Cyclos;


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


    public function send()
    {

    }


    public function _parseResponse()
    {
        
    }
}
