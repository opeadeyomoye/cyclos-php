<?php

namespace Cyclos\Http\Clients;

use Cyclos\Configuration\Configuration;
use Cyclos\Http\ClientInterface;
use Cyclos\Operation;
use Cyclos\OperationAwareTrait;
use Cyclos\Response\Response;

/**
 * Class BaseClient
 *
 * @package Cyclos\Http\Clients
 *
 * @todo be sure to explicitly set user-agent for requests
 * @todo Consider making this class into a trait
 */
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

    /**
     * @var bool Whether or not the request to be sent needs the authorization header.
     */
    protected $needsAuthorization = true;


    /**
     * Set the current operation.
     *
     * @param Operation $operation
     * @return $this
     */
    public function setOperation(Operation $operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * Set the Cyclos configuration object for
     * subsequent requests with this client.
     *
     * @param Configuration $config
     * @return $this
     */
    public function setConfig(Configuration $config)
    {
        $this->operation->setConfig($config);
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $header
     * @return $this
     */
    public function withHeader($header, $value = null)
    {
        if (is_array($header)) {
            foreach ($header as $key => $val) {
                $this->operation->addHeader($key, $val);
            }
        } else {
            $this->operation->addHeader($header, $value);
        }
        return $this;
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
     * @return static
     */
    public function withBody($data)
    {
        $this->body = $data;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return static
     */
    public function withoutAuthorization()
    {
        $this->needsAuthorization = false;
        return $this;
    }

    /**
     * Construct a response object.
     *
     * @param mixed     $model
     * @param Operation $operation
     * @param int       $code
     * @param array     $headers
     * @param \stdClass $body
     *
     * @return Response
     */
    public function makeResponse($model = null, Operation $operation, $code, array $headers, $body)
    {
        return Response::make($model, $operation, $code, $headers, $body);
    }
}
