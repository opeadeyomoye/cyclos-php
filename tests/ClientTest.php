<?php

namespace Cyclos\Tests;

//use Cyclos\Client;
use Cyclos\Http\ClientAwareTrait;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class ClientTest extends PHPUnitTestCase
{
    use ClientAwareTrait;
    
    public function setUp()
    {
        // nothing to set up. yet.
    }

    public function tearDown()
    {
        // nothing to tear down. yet.
    }

    /**
     * Tests that the default http(ful) client can be loaded without errors.
     *
     * @return void
     */
    public function testDefaultHttpClientCanBeLoaded()
    {
        $this->assertInstanceOf('\Cyclos\Client', $this->getClient());
    }

    public function testMagicMethodsAreCalledOnHttpClient()
    {
        $client = $this->getClient('Httpful');

        // here, we need a method defined in an http client class, that doesn't
        // have a corresponding method of the same name in the \Cyclos\Client class.
    }
}
