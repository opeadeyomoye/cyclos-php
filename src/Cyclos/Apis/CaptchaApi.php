<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 10/5/17
 * Time: 12:33 PM
 */

namespace Cyclos\Apis;

use Cyclos\Configuration\ConfigAwareTrait;
use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;


class CaptchaApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function generate($group = null)
    {
        $path = '/captcha';
        $query = $group ? ['group' => $group] : [];
        $method = 'post';

        $operation = $this->makeOperation(compact('path', 'query', 'method'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation);
    }

    public function getImage($captchaId, $query = [])
    {
        $path = '/captcha/' . $captchaId;
        $method = 'get';
        $headers = ['Accept' => 'image/png'];

        $operation = $this->makeOperation(compact('path', 'query', 'method', 'headers'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation);
    }
}
