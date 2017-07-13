<?php

namespace Cyclos\Http\Clients;

use Cyclos\Configuration\Configuration;
use Cyclos\Http\ClientInterface;
use Cyclos\Operation;
use Cyclos\OperationAwareTrait;
use Cyclos\Response\Response;

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

    public function setConfig(Configuration $config)
    {
        $this->operation->setConfig($config);
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


    /**
     * Undocumented function
     *
     * @param mixed $model
     * @param Operation $operation
     * @param int $code
     * @param array $headers
     * @param stdClass $body
     * @return void
     */
    public function makeResponse($model = null, Operation $operation, $code, array $headers, $body)
    {
        return Response::make($model, $operation, $code, $headers, $body);
    }
}
