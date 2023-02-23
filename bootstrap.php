<?php

use Hotels\xlr8\Service\HotelService;
use DI\Container;
use Hotels\xlr8\Controller\HotelController;

$container = new Container();


$container->set('hotelService', function ($container) {
    return new HotelService($container);
});

$container->set('hotelController', function ($container) {
    return new HotelController($container);
});


return $container;
