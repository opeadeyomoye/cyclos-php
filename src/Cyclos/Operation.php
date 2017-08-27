<?php

namespace Cyclos;


use Cyclos\Configuration\Configuration;

/**
 * Class Operation
 *
 * Encapsulates details about a request to a specific endpoint e.g. endpoint path,
 * request method, default content-type and accepts headers, etc.
 *
 * @package Cyclos
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

    protected $properties = [
        'path' => '',
        'query' => [],
        'method' => '',
        'headers' => [], // name-value array of headers
        'configuration' => null
    ];

    public function __construct($data = [])
    {
        $this->container = array_merge($this->container, $this->properties);
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

    /**
     * Return an array of preset query parameters and values.
     *
     * @return array
     */
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


    public function setConfig(Configuration $config)
    {
        $this->offsetSet('configuration', $config);
        return $this;
    }


    /**
     * Return this operation's config object.
     *
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->offsetGet('configuration');
    }

    public function addHeader($name, $value)
    {
        $headers = $this->offsetGet('headers');
        $headers[$name] = $value;
        $this->setHeaders($headers);
        return $this;
    }


    /**
     * Return the full URL for the current request.
     *
     * @return string
     * 
     * @throws \Exception If no configuration has been set.
     */
    public function getUrl()
    {
        $config = $this->getConfig();
        if (!($config instanceof Configuration)) {
            throw new \Exception(
                "Can't get request URL: No configuration object has been set for the Cyclos request."
            );
        }
        $url = rtrim($config->getRootUrl(), '/api') . '/api';
        $url .= rtrim($this->getPath(), '/');

        if (!empty($this->getQuery())) {
            $url .= '?'.$this->getQueryString();
        }
        return $url;
    }

    /**
     * Get the query string for the current request.
     *
     * @return string
     */
    public function getQueryString()
    {
        return \http_build_query($this->getQuery());
    }
}
