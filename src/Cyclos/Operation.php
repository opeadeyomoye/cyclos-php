<?php

namespace Cyclos;

use Cyclos\ArrayAccessTrait;

/**
 * Encapsulates details about a request to a specific endpoint
 * e.g. endpoint path, request method, default content-type
 * and accepts headers, etc.
 * 
 * @todo Operation class should function as request class?
 */
class Operation
{
    use ArrayAccessTrait;

    // request method constants
    const METHOD_GET = 'get';
    const METHOD_PUT = 'put';
    const METHOD_POST = 'post';
    const METHOD_DELETE = 'delete';

    protected $container = [
        'path' => '',
        'query' => '',
        'method' => '',
        'headers' => [] // name-value array of headers
    ];

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->patchIn($data);
        }
    }

    public function setPath($path)
    {
        $this->offsetSet('path', $path);
        return $this;
    }

    public function getPath()
    {
        return $this->offsetGet('path');
    }

    public function setQuery(array $query)
    {
        $this->offsetSet('query', $query);
        return $this;
    }

    public function getQuery()
    {
        return $this->offsetGet('query');
    }

    public function addQueryParam($key, $value)
    {
        $query = $this->getQuery();
        $query[$key] = $value;
        $this->setQuery($query);
        return $this;
    }

    public function setMethod($method)
    {
        $this->offsetSet('method', $method);
        return $this;
    }

    public function getMethod()
    {
        return $this->offsetGet('method');
    }


    public function setHeaders(array $headers)
    {
        $this->offsetSet('headers', $headers);
        return $this;
    }

    public function getHeaders()
    {
        return $this->offsetGet('headers');
    }

    public function addHeader($name, $value)
    {
        $headers = $this->offsetGet('headers');
        $headers[$name] = $value;
        $this->setHeaders($headers);
        return $this;
    }

    public function getUrl()
    {
        
    }
}
