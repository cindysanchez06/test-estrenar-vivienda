<?php

namespace Drupal\posts\Services;

use Drupal\api\Services\RequestService;

class PostsServices
{
    protected RequestService $apiRequestService;

    public function __construct(RequestService $requestService)
    {
        $this->apiRequestService = $requestService;
    }

    public function getPosts()
    {
        $url = 'https://jsonplaceholder.typicode.com/posts';
        $method = 'GET';
        return $this->apiRequestService->requests($method, $url);
    }
}