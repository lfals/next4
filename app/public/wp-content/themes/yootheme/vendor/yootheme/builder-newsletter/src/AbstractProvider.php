<?php

namespace YOOtheme\Builder\Newsletter;

use YOOtheme\HttpClientInterface;

abstract class AbstractProvider
{
    protected $apiKey;

    protected $apiEndpoint = '';

    /**
     * @var HttpClientInterface
     */
    protected $client;

    public function __construct($apiKey, HttpClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @param array $provider
     *
     * @throws \Exception
     *
     * @return array
     */
    abstract public function lists($provider);

    /**
     * @param string $email
     * @param array  $data
     * @param array  $provider
     *
     * @throws \Exception
     *
     * @return bool
     */
    abstract public function subscribe($email, $data, $provider);

    /**
     * @return string[]
     */
    protected function getHeaders()
    {
        return [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @throws \Exception
     *
     * @return array
     */
    public function get($name, $args = [])
    {
        return $this->request('GET', $name, $args);
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @throws \Exception
     *
     * @return array
     */
    public function post($name, $args = [])
    {
        return $this->request('POST', $name, $args);
    }

    /**
     * @param string $method
     * @param string $name
     * @param array  $args
     *
     * @throws \Exception
     *
     * @return array
     */
    protected function request($method, $name, $args)
    {
        $url = "{$this->apiEndpoint}/{$name}";

        $headers = $this->getHeaders() + [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];

        switch ($method) {
            case 'GET':

                $query = http_build_query($args, '', '&');
                $response = $this->client->get("{$url}?{$query}", compact('headers'));
                break;
            case 'POST':

                $response = $this->client->post($url, json_encode($args), compact('headers'));
                break;

            default:
                throw new \Exception("Call to undefined method {$method}");
        }

        $encoded = json_decode($response->getBody(), true);
        $success = $response->getStatusCode() >= 200 && $response->getStatusCode() <= 299 && $encoded;

        return [
            'success' => $success,
            'data' => $success ? $encoded : $this->findError($response, $encoded),
        ];

    }

    /**
     * Get error message from response.
     *
     * @param $response
     * @param $formattedResponse
     *
     * @return string
     */
    protected function findError($response, $formattedResponse)
    {
        return isset($formattedResponse['detail'])
            ? $formattedResponse['detail']
            : 'Unknown error, call getLastResponse() to find out what happened.';
    }
}
