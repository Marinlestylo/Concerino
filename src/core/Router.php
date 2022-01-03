<?php

namespace App\Core;
use Exception;

class Router{
    protected $routes = [
        'GET' => [],
        'POST' =>[]
    ];

    public static function load($file){
        $router = new static;

        require $file;

        return $router;
    }
    
    public function get($uri, $controller){
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller){
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType){
        if(array_key_exists($uri, $this->routes[$requestType])){
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])// Les ... permettent de split un tableau en plusieurs valeurs qui sont pris en param par la fonction
            );
        }

        throw new Exception('No route defined for this URI');
    }

    protected function callAction($controller, $action){
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;
        if(! method_exists($controller, $action)){
            throw new Exception("{$controller} does not respond to the {$action} action.");
        }

        return $controller->$action();
    }
}