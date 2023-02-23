<?php

namespace Hotels\xlr8\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HotelController
{
    protected $container;
    private $hotelService;

    public function __construct($container)
    {
        $this->container = $container;
        $this->hotelService = $container->get('hotelService');
    }

    public function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write($this->hotelService->getNearbyHotels());
        return $response;
    }
}