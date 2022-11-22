<?php

namespace Drupal\api\Services;

class RequestService
{
    private $client;

    public function __construct()
    {
        $this->client = \Drupal::httpClient();
    }

    public function requests(string $method, string $url, array $headers = [], array $body = []): array
    {
        $response = $this->client->request(
            $method,
            $url,
            [
                'headers' => $headers,
                'form_params' => $body
            ]
        );
        return json_decode($response->getBody(), TRUE);
    }
}