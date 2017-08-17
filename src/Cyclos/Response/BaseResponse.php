<?php

namespace Cyclos\Response;

use Cyclos\Operation;

abstract class BaseResponse implements ResponseTypeInterface
{
    /**
     * @var integer HTTP response code for the concerned request.
     */
    protected $code;

    /**
     * @var mixed The body of the response.
     */
    protected $body;

    /**
     * @var array An array of response headers.
     */
    protected $headers;

    /**
     * @var Operation Cyclos\Operation object associated with the related request.
     */
    protected $operation;

    public function __construct(Operation $operation, $code, array $headers, $body)
    {
        $this->operation = $operation;
        $this->code      = $code;
        $this->headers   = $headers;
        $this->body      = $body;

        // $this->initialize(); // is there a need for an initialization hook?
    }

    /**
     * See whether the request had errors.
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return ($this->code >= 400);
    }

    /**
     * See whether the request was fine.
     *
     * @return boolean
     */
    public function hasNoErrors()
    {
        return !($this->hasErrors());
    }

    /**
     * Alias to $this->hasNoErrors()
     *
     * @return boolean
     */
    public function isCool()
    {
        return $this->hasNoErrors();
    }


    // getters...
    public function getBody()
    {
        return $this->body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getOperation()
    {
        return clone $this->operation;
    }

    public function getRootUrl()
    {
        return $this->getOperation()->getConfig()->getRootUrl();
    }
}