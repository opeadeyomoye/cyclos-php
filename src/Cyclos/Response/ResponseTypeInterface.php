<?php

namespace Cyclos\Response;

interface ResponseTypeInterface
{
    public function hasErrors();

    public function hasNoErrors();
}
