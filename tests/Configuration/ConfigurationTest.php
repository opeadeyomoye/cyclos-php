<?php

namespace Cyclos\Tests\Configuration;

use Cyclos\Configuration\ConfigAwareTrait;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class ConfigurationTest extends PHPUnitTestCase
{
    use ConfigAwareTrait;

    public function setUp()
    {

    }

    public function tearDown()
    {
        
    }

    public function testGet()
    {
        $config = $this->getConfig();

        // we're trying to see whether the default properties get set
        // update: they're in fact, set. But privately. This may be because the
        // configuration class' constructor is private.
    }
}
