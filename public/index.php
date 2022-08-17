<?php

use App\core\Application;
use App\controllers\SiteController;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);

$app->router->post('/contact', [SiteController::class, 'contact']);

$app->run();
