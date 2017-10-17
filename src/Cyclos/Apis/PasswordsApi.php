<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 10/17/17
 * Time: 7:15 PM
 */

namespace Cyclos\Apis;


use Cyclos\Configuration\ConfigAwareTrait;
use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;

class PasswordsApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function changePassword($type, $data, $user = 'self')
    {
        $path = "/{$user}/passwords/{$type}/change";
        $method = 'post';
        $headers = ['Content-type' => 'application/json'];

        $operation = $this->makeOperation(compact('path', 'method', 'headers'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation)->withBody($data);
    }
}