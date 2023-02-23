<?php

namespace Hotels\xlr8\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HotelController
{
    public function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write('Hello World from Controller!');
        return $response;
    }
}