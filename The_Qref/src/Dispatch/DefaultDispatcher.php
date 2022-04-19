<?php

namespace Dispatch;

use Routing\Route;
use Routing\RoutingException;

class DefaultDispatcher implements Dispatcher {

    private static DefaultDispatcher $instance;

    private Route $matched;

    private function __construct() {
    }

    public static function instance() {
        if (!isset(self::$instance)) {
            self::$instance = new DefaultDispatcher();
        }
        return self::$instance;
    }

    public function getMatched(): Route{
        return $this->matched;
    }

    public function dispatch() {

        $request_URI = strtok($_SERVER["REQUEST_URI"], "?");

        foreach (Route::get() as $route){
            if ($route->match($request_URI)){
                $this->matched = $route;
                break;
            }
        }
        if (!isset($this->matched)){
            throw new RoutingException("No route matched for: \"$request_URI\"");
        }
        $controller_name = "\\Controller\\" . $this->matched->getParam("controller");
        if (!class_exists($controller_name)){
            throw new RoutingException("Controller: \"$controller_name\" doesn't exist");
        }
        $controller = new $controller_name();
        $action = $this->matched->getParam("action");
        if (!method_exists($controller, $action)){
            throw new RoutingException("Controller: \"$controller_name\" doesn't have action: \"$action\"");
        }
        if ($this->matched->getParam("require_auth") and  !isset($_SESSION["user"])){
            throw new RoutingException("You are not authorized to access this page!");
        }
        $controller->$action();



    }
}