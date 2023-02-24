<?php

namespace Hotels\xlr8\Service;

use Psr\Container\ContainerInterface;

class HotelService
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function hello()
    {
        return "Hello World!";
    } 

    public function getNearbyHotelsService($latitude, $longitude, $order)
    {
        return "Hello World!: $latitude $longitude $order";
    }
}
