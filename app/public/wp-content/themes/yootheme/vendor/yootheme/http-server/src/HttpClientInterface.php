<?php

namespace YOOtheme;

interface HttpClientInterface
{
    /**
     * Execute a GET HTTP request.
     *
     * @param string $url
     * @param array  $options
     *
     * @return mixed
     */
    public function get($url, $options = []);

    /**
     * Execute a POST HTTP request.
     *
     * @param string $url
     * @param string $data
     * @param array  $options
     *
     * @return mixed
     */
    public function post($url, $data = null, $options = []);

    /**
     * Execute a PUT HTTP request.
     *
     * @param string $url
     * @param string $data
     * @param array  $options
     *
     * @return mixed
     */
    public function put($url, $data = null, $options = []);

    /**
     * Execute a DELETE HTTP request.
     *
     * @param string $url
     * @param array  $options
     *
     * @return mixed
     */
    public function delete($url, $options = []);
}
