<?php
namespace System\Routing;
use App\Http\Request;
use System\Container\RouteContainer as Container;
use System\Http\Httpkernel;

class RouteHandler extends Httpkernel{

    private $route;

    private $controller;
    private $http;
    private $uri;
    private $method;
    private $group;
    private $midware;
    private $name;

    public function __construct(Array|Object $route)
    {
        if (is_object($route)) {
            $this->group($route);
        } else {
            if (!empty($route['http'])) $this->http = $route['http'];
            if (!empty($route['uri'])) $this->uri = trim($route['uri'], '/');
            if (!empty($route['method'])) $this->method = $route['method'];
            if (!empty($route['controller'])) $this->controller = $route['controller'];
            if (!empty($route['middleware'])) $this->midware = $route['middleware'];
            if (!empty($route['prefix'])) Container::put('prefix', $route['prefix']);
        }
    }

    public function group(Object $func)
    {
        $this->group = $func;
        return $this;
    }

    public function get(String $uri, Array|Object|String $method)
    {
        $this->http = "GET";
        $this->uri = trim($uri, '/');
        $this->method = $method;
        return $this;
    }

    public function post(String $uri, Array|Object|String $method)
    {
        $this->http = "POST";
        $this->uri = trim($uri, '/');
        $this->method = $method;
        return $this;
    }

    public function put(String $uri, Array|Object|String $method)
    {
        $this->http = "PUT";
        $this->uri = trim($uri, '/');
        $this->method = $method;
        return $this;
    }

    public function delete(String $uri, Array|Object|String $method)
    {
        $this->http = "DELETE";
        $this->uri = trim($uri, '/');
        $this->method = $method;
        return $this;
    }

    public function prefix(String $prefix)
    {
        Container::put('prefix', $prefix);
        return $this;
    }

    private function whenMethodisArray(Array $method)
    {
        $this->controller = $method[0];
        $this->method = $method[1];
    }

    private function prefixHandle(String $uri)
    {
        return Container::get('prefix')."/".$uri;
    }

    public function middleware(String|Array $middleware)
    {
        $this->midware = $middleware;
        return $this;
    }

    private function setMiddleware(String|null $middleware)
    {
        $array = array_flip($this->middleware);
        return array_search($middleware, $array);
    }

    public function __destruct()
    {


        if (is_array(($this->method))) $this->whenMethodisArray($this->method);

        if (!empty($this->group)) {

            Container::put('controller', $this->controller);
            Container::put('middleware', $this->midware);
            Container::put('name', $this->name);
            call_user_func($this->group);
            Container::clear();

        }else{

            $controller = (empty(Container::get('controller'))) ? $this->controller : Container::get('controller');
            $middleware = (!empty($this->midware)) ? $this->midware : Container::get('middleware');
            $http = (!empty($this->http)) ? $this->http : Container::get('http');
            $uri = (!empty($this->uri)) ? $this->uri : Container::get('uri');
            $method = (!empty($this->method)) ? $this->method : Container::get('method');
            $name = (!empty($this->name)) ? $this->name : Container::get('name');

            $uri = (!empty(Container::get('prefix'))) ? $this->prefixHandle($uri) : $uri;
            
            $this->route = [
                'http' => $http,
                'uri' => trim($uri, '/'),
                'controller' => $controller,
                'method' => $method,
                'middleware' => $this->setMiddleware($middleware),
            ];

            if (!empty($this->route['uri'])) \System\Routing\RouteCollection::add($this->route);
            $this->dispatcher(new Request, $this->route);
        }
    }

}