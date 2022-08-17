<?php

namespace App\core;

use App\core\Application;

class Controller {

    public string $page = '';

    public function __construct() {}

    public function render($view, $params = []) {
        return Application::$app->router->renderView($view, $params);
    }
    
}
