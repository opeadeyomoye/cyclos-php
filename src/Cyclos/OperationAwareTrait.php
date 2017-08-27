<?php

namespace Cyclos;

/**
 * Class OperationAwareTrait
 *
 * Provides methods for creating/retrieving operation objects.
 *
 * @package Cyclos
 */
trait OperationAwareTrait
{
    /**
     * @var Operation
     */
    protected $operation;

    /**
     * Return a new \Cyclos\Operation object,
     * patching in any data available.
     *
     * @param array $data
     *
     * @return Operation
     */
    public function makeOperation($data = [])
    {
        return new Operation($data);
    }


    /**
     * Retrieve the current class' \Cyclos\Operation object.
     *
     * @param array $data
     *
     * @return Operation
     */
    public function getOperation($data = [])
    {
        if (!$this->operation) {
            $this->operation = $this->makeOperation($data);
        }
        return $this->operation;
    }
}