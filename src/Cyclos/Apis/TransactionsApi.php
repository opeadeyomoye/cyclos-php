<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 10/11/17
 * Time: 1:36 PM
 */

namespace Cyclos\Apis;

use Cyclos\Configuration\ConfigAwareTrait;
use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;


class TransactionsApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function get($transactionId)
    {
        $path = '/transactions/' . $transactionId;
        $method = 'get';

        $operation = $this->makeOperation(compact('path', 'method'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation);
    }

    public function all($username, $options = [])
    {
        $path = "/{$username}/transactions/?" . http_build_query($options);
        $method = 'get';

        $operation = $this->makeOperation(compact('path', 'method'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation);
    }

    public function fromAccount($accountId, $options = [])
    {

    }
}
