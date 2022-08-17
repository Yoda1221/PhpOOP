<?php

namespace App\core;

use App\core\Router;
use App\core\Request;
use App\core\Response;

class Application {

    public Router $router;
    public Request $request;
    public Response $response;
    public static string $ROOT_DIR;
    public static Application $app;

    public function __construct($rootPath/* , array $config */) {
        self::$app      = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request  = new Request();
        $this->response = new Response();
        $this->router   = new Router($this->request, $this->response);
    }

    /**
     ** RUN THE APPLICATION
     *
     * @return void
     */
    public function run() {
        echo $this->router->resolve();
    }

}
