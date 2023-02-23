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

    public function getNearbyHotels()
    {
        return "Hello World!";
    }
}
