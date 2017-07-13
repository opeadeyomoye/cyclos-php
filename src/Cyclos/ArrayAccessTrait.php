<?php

namespace Cyclos;

/**
 * An implementation of the \ArrayAccess interface.
 * 
 * Based (almost-entirely) off of https://bitbucket.org/dgifford/array-access-trait/
 */
trait ArrayAccessTrait
{
    protected $container = [];

    public function offsetSet($index, $properties)
    {
        if (is_null($index)) {
            $this->container[] = $properties;
        } else {
            $this->container[$index] = $properties;
        }
    }

    public function offsetExists($index)
    {
        return isset($this->container[$index]);
    }

    public function offsetUnset($index)
    {
        if (isset($this->container[$index])) {
            unset($this->container[$index]);
        }
    }

    public function offsetGet($index)
    {
        if (isset($this->container[$index])) {
            return $this->container[$index];
        }
        return null;
    }
    
    public function patchIn($data)
    {
        return $this->container = array_merge($this->container, $data);
    }
}
