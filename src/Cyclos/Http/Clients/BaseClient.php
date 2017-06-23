<?php

namespace Cyclos\Http\Clients;

use Cyclos\Operation;
use Cyclos\OperationAwareTrait;
use Cyclos\Http\ClientInterface;

// @todo be sure to explicity set user agent for requests
abstract class BaseClient implements ClientInterface
{
    use OperationAwareTrait;

    /**
     * @var mixed Body of the current request.
     */
    protected $body;

    /**
     * @var [type]
     */
    protected $expectedModel;

    public function setOperation(Operation $operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $header
     * @return Operation
     */
    public function withHeader($header)
    {
        return $this->operation->addHeader($header);
    }


    /**
     * {@inheritDoc}
     *
     * @param mixed $model
     * @return $this
     */
    public function expect($model)
    {
        $this->expectedModel = $model;
        return $this;
    }


    /**
     * {@inheritDoc}
     *
     * @param mixed $data
     * @return $this
     */
    public function withBody($data)
    {
        $this->body = $data;
        return $this;
    }
}
