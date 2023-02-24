<?php

require dirname(__DIR__) . '/vendor/autoload.php';
$container = require dirname(__DIR__) . '/bootstrap.php';

use Slim\Factory\AppFactory;
use Hotels\xlr8\Controller\HotelController;

$app = AppFactory::createFromContainer($container);

$app->get('/', [HotelController::class, 'index']);

$app->get('/getNearbyHotels/{latitude}/{longitude}/{order}', [HotelController::class, 'getNearbyHotelsController']);

$app->run();
