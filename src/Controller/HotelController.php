<?php

namespace Hotels\xlr8\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HotelController
{
    private $hotelService;

    public function __construct(ContainerInterface $container)
    {
        $this->hotelService = $container->get('hotelService');
    }

    public function getNearbyHotelsController(Request $request, Response $response, $args)
    {
        $latitude = $request->getAttribute('latitude');
        $longitude = $request->getAttribute('longitude');
        $order = $request->getAttribute('order');

        $response->getBody()->write(json_encode($this->hotelService->getNearbyHotelsService($latitude, $longitude, $order)));
        return $response;

    }
}
