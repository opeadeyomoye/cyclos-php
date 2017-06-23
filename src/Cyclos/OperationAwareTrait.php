<?php

namespace Cyclos;

trait OperationAwareTrait
{
    /**
     * @var Operation
     */
    protected $operation;

    /**
     * Undocumented function
     *
     * @param array $data
     * @return Operation
     */
    public function makeOperation($data = [])
    {
        return new Operation($data);
    }


    public function getOperation($data = [])
    {
        if (!$this->operation) {
            $this->operation = $this->makeOperation($data);
        }
        return $this->operation;
    }
}