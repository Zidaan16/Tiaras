<?php
namespace System\Routing;
use App\Http\Request;
use App\Http\Response;


trait Dispatcher {

    public function dispatcher(Request $request, Array $route)
    {
        if (!empty($request->server('REQUEST_URI'))) {
            
            $url = trim($request->server('REQUEST_URI'), '/');
            $uri = false;
            $method = false;

            switch (true) {
                // route
                case $this->match($url, $route['uri']):
                    $uri = true;

                // method
                case $this->match($request->server('REQUEST_METHOD'), $route['http']);
                    $method = true;

                default:
                    $this->result($uri, $method, $route['controller'], $route['method'], $route['middleware']);
                    break;

            }
        }
        
    }

    protected function result(Bool $uri, Bool $http, $controller, $method, String|Null $middleware = null)
    {
        if ($uri) {

            if ($http) {

                if (!empty($middleware)) {

                    $class = explode('\\', $middleware);
                    require_once '../App/Middleware/'.end($class).'.php';
                    return call_user_func([new $middleware, 'handle'],
                        new Request,
                        function () use ($controller, $method){
                            new Response(function () use ($controller, $method){
                                return call_user_func([new $controller, $method]);
                            });
                        }
                    );

                } else {

                    if (is_callable($method)) {

                        return new Response(function () use ($method) {
                            return call_user_func($method);
                        }, 200);

                    } else {

                        return new Response(function () use ($controller, $method) {
                            return call_user_func([new $controller, $method]);
                        }, 200);

                    }

                }
            }

        }
    }

    protected function match(String $value, String $value2)
    {
        if ($value == $value2) return true;
        else return false;
    }

}
