<?php

namespace App\controllers;

use App\core\Request;
use App\core\Controller;
use App\core\Application;

class SiteController extends Controller {

    public function __construct() {

    }

    public static function home() {
        $name = "Yoda";
        $params = [
            'name' => $name
        ];
        // $this->render //!NOT WORKING ???
        return Application::$app->router->renderView('home', $params);
    }

    public static function contact(Request $request) {
        if ($request->isPost()) { 
            $body = $request->getBody();
            return $body['subject'];
        }
        $params = [];
        return Application::$app->router->renderView('contact', $params);
    }

}
