<?php

namespace Cyclos\Configuration;

trait ConfigAwareTrait
{
    public function getConfig()
    {
        return \Cyclos\Configuration\Configuration::get();
    }

    public function getGlobalConfig()
    {
        return \Cyclos\Configuration\Configuration::getGlobalConfig();
    }
}
