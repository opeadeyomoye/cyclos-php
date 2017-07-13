<?php

namespace Cyclos\Response;

use Cyclos\Operation;

class Response extends BaseResponse
{
    public static function make($model = null, Operation $operation, $code, array $headers, $body)
    {
        if ((is_null($model)) || !(is_string($model))) {
            $model = static::class;
        }
        
        // if the checks for the selected model class fail...
        return new static($operation, $code, $headers, $body);
    }
}
