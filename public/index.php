<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Slim\Factory\AppFactory;
use Hotels\xlr8\Controller\HotelController;

$app = AppFactory::create();

$app->get('/', [HotelController::class, 'index']);

$app->run();