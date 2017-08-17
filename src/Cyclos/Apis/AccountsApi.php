<?php

namespace Cyclos\Apis;

use Cyclos\Configuration\ConfigAwareTrait;
use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;

class AccountsApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function all($username, array $fields = [])
    {
        $pathSuffix = '';
        if (!empty($fields)) {
            foreach($fields as $field) {
                $pathSuffix .= "&fields={$field}";
            }
            $pathSuffix = ltrim($pathSuffix, '&');
        }

        $path = "/{$username}/accounts" . $pathSuffix;
        $method = 'get';
        $headers = ['Content-type' => 'application/json'];

        $operation = $this->makeOperation(compact('path', 'method', 'headers'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()
            ->setOperation($operation)
            ->expect(['model' => 'Accounts[]']);
    }
}