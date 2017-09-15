<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 9/15/17
 * Time: 5:36 AM
 */

namespace Cyclos\Apis;


use Cyclos\Configuration\ConfigAwareTrait;
use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;

class PaymentsApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function perform(array $payment, $owner = null, array $fields = [])
    {
        $pathSuffix = '';
        if (!empty($fields)) {
            foreach($fields as $field) {
                $pathSuffix .= "&fields={$field}";
            }
            $pathSuffix = ltrim($pathSuffix, '&');
        }
        $pathSuffix = '?' . $pathSuffix;

        $owner = is_null($owner) ? 'self': $owner;
        $path = "/{$owner}/payments" . $pathSuffix;
        $method = 'post';
        $headers = ['Content-type' => 'application/json'];

        $operation = $this->makeOperation(compact('path', 'method', 'headers'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()
            ->setOperation($operation)
            ->withBody($payment);
    }

    public function preview(array $payment, $owner = null, array $fields = [])
    {
        $pathSuffix = '';
        if (!empty($fields)) {
            foreach($fields as $field) {
                $pathSuffix .= "&fields={$field}";
            }
            $pathSuffix = ltrim($pathSuffix, '&');
        }
        $pathSuffix = '?' . $pathSuffix;

        $owner = is_null($owner) ? 'self': $owner;
        $path = "/{$owner}/payments/preview" . $pathSuffix;
        $method = 'post';
        $headers = ['Content-type' => 'application/json'];

        $operation = $this->makeOperation(compact('path', 'method', 'headers'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()
            ->setOperation($operation)
            ->withBody($payment);
    }
}