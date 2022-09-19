<?php

namespace zengine;

class Router{

    protected static $routes = [];

    protected static $route = [];

    public static function add($regexp, $route = []){
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes(){
        return self::$routes;
    }

    public static function getRoute(){
        return self::$route;
    }

    public static function dispatch($url){
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)){
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route["controller"] . 'Controller';
            if(class_exists($controller)){
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                    $controllerObject->getView();
                }else{
                    throw new \Exception('Method '. $controller::$action . ' not found', 404);
                }
            }else{
                throw new \Exception('Controller '. $controller .' not found', 404);
            }
        }else{
            throw new \Exception('Page not found', 404);
        }
    }

    public static function matchRoute($url){
        foreach (self::$routes as $pattern=>$route){
            if (preg_match("#($pattern)#", $url, $matches)){
                foreach ($matches as $k=>$v){
                    if (is_string($k)){
                        $route[$k] = $v;
                    }
                }
                if (empty($route['action'])){
                    $route['action'] = 'index';
                }
                if (empty($route["prefix"])){
                    $route["prefix"] = '';
                }else{
                    $route["prefix"] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    protected static function string_con($str, $string){
        $ready = str_replace($str, '', $string);
        if ($ready == $string){
            return false;
        }else{
            return true;
        }
    }

    protected static function upperCamelCase($name){
        $name = ucwords(str_replace('-', ' ', $name));
        $name = str_replace(' ', '', $name);
        return $name;
    }

    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));       
    }

    protected static function removeQueryString($url){
        if ($url){
            $url = explode('?', $url)[0];
        }
        return $url;
    }
}