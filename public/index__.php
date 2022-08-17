<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\core\Application;
use App\controllers\SiteController;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn'   => $_ENV['DB_DSN'],
        'user'  => $_ENV['DB_USER'],
        'pass'  => $_ENV['DB_PASS']
    ]
];

$app = new Application(dirname(__DIR__), $config);

//** SITES
$app->router->get('/', [SiteController::class, 'home']);

$app->run();
