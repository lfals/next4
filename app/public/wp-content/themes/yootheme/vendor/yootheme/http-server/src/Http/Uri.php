<?php

namespace YOOtheme\Http;

class Uri extends Message\Uri
{
    /**
     * Retrieve query string arguments.
     *
     * @return array
     */
    public function getQueryParams()
    {
        parse_str($this->getQuery(), $query);

        return $query;
    }

    /**
     * Retrieve a value from query string arguments.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getQueryParam($key, $default = null)
    {
        $query = $this->getQueryParams();

        return isset($query[$key]) ? $query[$key] : $default;
    }

    /**
     * Return an instance with the specified query parameters.
     *
     * @param array $parameters
     *
     * @return static
     */
    public function withQueryParams(array $parameters)
    {
        return $this->withQuery(http_build_query($parameters, '', '&'));
    }
}
