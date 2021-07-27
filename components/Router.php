<?php

namespace Components;

class Router {

    private $routes;
    public function __construct() {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = \Components\Config::get('routes');
    }

    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {
        $uri = $this->getURI();
        $uri = preg_replace('/\?.*/', '', $uri);
        $routExecuted = false;

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments);
                $controllerName = ucfirst($controllerName);

                $methodName = array_shift($segments);
                $parameters = $segments;
                
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if (!file_exists($controllerFile)) continue;
                $controllerName = 'Controllers\\' . $controllerName;
                
                $controllerObject = new $controllerName();
                if (!method_exists ( $controllerObject ,  $methodName )) continue;
                
                $result = call_user_func_array(array($controllerObject, $methodName), $parameters);
                $routExecuted = true;
                break;
            }
        }
        if (!$routExecuted) {
            redirect('/404');
        }
    }

}
