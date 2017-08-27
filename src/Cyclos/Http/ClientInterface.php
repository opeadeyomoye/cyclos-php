<?php

namespace Cyclos\Http;

use Cyclos\Operation;

/**
 * Interface ClientInterface
 *
 * Property and method definitions for anyone who wants to be a Cyclos client.
 *
 * @package Cyclos\Http
 */
interface ClientInterface
{
    /**
     * Add an operation object.
     *
     * @param Operation $operation
     * @return ClientInterface
     */
    public function setOperation(Operation $operation);

    /**
     * Get the client's operation object.
     *
     * @return Operation
     */
    public function getOperation();

    /**
     * Add an HTTP header to the current request.
     * 
     * @param string|array $header
     * @param string|null  $value
     * 
     * @return ClientInterface
     */
    public function withHeader($header, $value = null);

    /**
     * Specify the model to base the (successful) response on.
     *
     * @param string $model
     * @return ClientInterface
     */
    public function expect($model);

    /**
     * Add a payload to the current request.
     *
     * @param mixed $data
     * @return ClientInterface
     */
    public function withBody($data);

    /**
     * Send the current request.
     *
     * @return \Cyclos\Response\Response
     */
    public function send();
}
