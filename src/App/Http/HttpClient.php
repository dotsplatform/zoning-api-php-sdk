<?php
/**
 * Description of HttpClient.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Liuba Kalyta <kalyta@dotsplatform.com>
 */

namespace Dotsplatform\Zoning\Http;

use Dotsplatform\Zoning\Http\Exception\ZoningHttpClientException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class HttpClient
{
    protected GuzzleClient $client;

    public function __construct(
        private string $serviceHost
    ) {
    }

    protected function makeClient(): GuzzleClient
    {
        if (!isset($this->client)) {
            $this->client = new GuzzleClient(
                [
                    'base_uri' => $this->serviceHost,
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]
            );
        }

        return $this->client;
    }

    protected function get(string $uri, array $params = []): array
    {
        $client = $this->makeClient();
        $response = $client->get($uri, $params);
        $statusCode = $response->getStatusCode();
        if ($statusCode === 404) {
            return [];
        }
        return $this->decodeResponse($response);
    }

    protected function post(string $uri, ?array $body = null, array $params = []): array
    {
        $client = $this->makeClient();
        $params = $this->prepareRequestBody($body, $params);

        try {
            $response = $client->post($uri, $params);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }
        $this->parseResponseStatus($response);
        return $this->decodeResponse($response);
    }

    protected function put(string $uri, ?array $body = null, array $params = []): array
    {
        $client = $this->makeClient();
        $params = $this->prepareRequestBody($body, $params);

        try {
            $response = $client->put($uri, $params);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        $this->parseResponseStatus($response);
        return $this->decodeResponse($response);
    }

    protected function delete(string $uri, array $params = []): array
    {
        $client = $this->makeClient();

        try {
            $response = $client->delete($uri, $params);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        }

        $this->parseResponseStatus($response);
        return $this->decodeResponse($response);
    }

    protected function parseResponseStatus(ResponseInterface $response): void
    {
        if ($response->getStatusCode() < 400) {
            return;
        }
        throw new ZoningHttpClientException(
            "Zoning Request failed with status code {$response->getStatusCode()}"
        );
    }

    private function prepareRequestBody(?array $body, array $params): array
    {
        if (!is_null($body)) {
            if (!empty($params['multipart'])) {
                $params['multipart'] = $body;
            } else {
                if (!empty($params['json'])) {
                    $params['json'] = $body;
                } else {
                    $params['form_params'] = $body;
                }
            }
        }
        return $params;
    }

    private function decodeResponse(ResponseInterface $response): array
    {
        $responseBody = (string)$response->getBody();
        $data = json_decode($responseBody, true);
        if (!$data) {
            return [];
        }
        return $data;
    }
}
