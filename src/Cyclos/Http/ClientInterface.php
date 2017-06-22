<?php

namespace Cyclos\Http;

use Cyclos\Operation;

/**
 * Undocumented interface
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
     * Add an HTTP header to the current request.
     * 
     * @param string $header
     * 
     * @return ClientInterface
     */
    public function withHeader($header);

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
     * @return void
     */
    public function send();
}
