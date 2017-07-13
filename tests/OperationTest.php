<?php

namespace Cyclos\Tests;

use Cyclos\OperationAwareTrait;
use Cyclos\Configuration\ConfigAwareTrait;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;


class OperationTest extends PHPUnitTestCase
{
    use ConfigAwareTrait;
    use OperationAwareTrait;

    public function setUp()
    {
        $this->operation = $this->makeOperation();
    }

    public function tearDown()
    {
        unset($this->operation);
    }

    public function testGetQueryString()
    {
        $this->operation->setQuery(['page' => 15, 'limit' => 'someKindaLimit']);
        $this->assertEquals('page=15&limit=someKindaLimit', $this->operation->getQueryString());
    }

    /**
     * Sees that we can get the correct full URLs for our requests.
     *
     * @return void
     */
    public function testCorrectRequestUrlCanBeGot()
    {
        $data = [
            'method' => 'get',
            'path' => '/transactions',
            'query' => [
                'page' => 1,
                'pageSize' => 10
            ],
            'configuration' => $this->getConfig()
        ];

        $this->operation->patchIn($data);
        $requestUrl = $this->operation->getUrl();
        $this->assertEquals('https://demo.cyclos.org/api/transactions?page=1&pageSize=10', $requestUrl);
    }
}