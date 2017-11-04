<?php
/**
 * Created by PhpStorm.
 * User: opeadeyomoye
 * Date: 10/5/17
 * Time: 4:31 PM
 */

namespace Cyclos\Apis;

use Cyclos\Configuration\ConfigAwareTrait;
use Cyclos\Http\ClientAwareTrait;
use Cyclos\OperationAwareTrait;

class UsersApi
{
    use ConfigAwareTrait;
    use ClientAwareTrait;
    use OperationAwareTrait;

    public function createUser(array $user = [])
    {
        $path = '/users';
        $method = 'post';
        $headers = ['Content-type' => 'application/json'];

        $operation = $this->makeOperation(compact('path', 'method', 'headers'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation)->withBody($user);
    }

    public function getGroupsForUserRegistration(array $fields = [], $asMember = null)
    {
        $pathSuffix = '';
        if (!empty($fields)) {
            foreach($fields as $field) {
                $pathSuffix .= "&fields={$field}";
            }
        }
        $pathSuffix .= is_null($asMember) ? '&asMember=' . $asMember : '';
        $pathSuffix = ltrim($pathSuffix, '&');
        $pathSuffix = '?' . $pathSuffix;

        $path = '/users/groups-for-registration' . $pathSuffix;
        $method = 'get';

        $operation = $this->makeOperation(compact('path', 'method'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation);
    }

    public function getUser($userId, array $fields = [])
    {
        $pathSuffix = '';
        if (!empty($fields)) {
            foreach($fields as $field) {
                $pathSuffix .= "&fields={$field}";
            }
        }
        $pathSuffix = ltrim($pathSuffix, '&');
        $pathSuffix = '?' . $pathSuffix;

        $path = "/users/{$userId}" . $pathSuffix;
        $method = 'get';

        $operation = $this->makeOperation(compact('path', 'method'));
        $operation->setConfig($this->getGlobalConfig());

        return $this->getClient()->setOperation($operation);
    }
}
