<?php
namespace System\Routing;
use App\Http\Request;
use System\Container\RouteContainer as Container;
use System\Http\Httpkernel;

class RouteHandler extends Httpkernel{

    private $route;

    private $id = 0;
    private $controller;
    private $http;
    private $uri;
    private $method;
    private $group;
    private $midware;
    private $name;

    public function __construct(Array|Object $route, \System\Feature\Collection|Null $collection = null)
    {
        if (is_object($route)) {

            $this->group($route);

        } else {
            
            if (!empty($collection)) {

                $this->patternHandle($collection);

            }

            if (!empty($route['http'])) $this->http = $route['http'];
            if (!empty($route['method'])) $this->method = $route['method'];
            if (!empty($route['controller'])) $this->controller = $route['controller'];
            if (!empty($route['middleware'])) $this->midware = $route['middleware'];
            if (!empty($route['prefix'])) Container::put('prefix', $route['prefix']);
        }
    }

    private function patternHandle($pattern)
    {
        switch ($pattern->getType()) {
            case 'array':

                foreach ($pattern->all() as $key => $value) {
                    if ($key == 'middleware') $this->midware = $value;
                    elseif ($key == 0) $this->uri = trim($value, '/');
                    else $this->$key = $value;
                }
                break;
            
            case 'string':
                $this->uri = trim($pattern->all(), '/');
                break;
        }
    }

    public function group(Object $func)
    {
        $this->group = $func;
        return $this;
    }

    public function name(String $name)
    {
        $this->name = $name;
        return $this;
    }

    public function get($uri, Array|Object|String $method)
    {
        $this->http = "GET";
        $this->patternHandle(new \System\Feature\Collection($uri));
        $this->method = $method;
        return $this;
    }

    public function post($uri, Array|Object|String $method)
    {
        $this->http = "POST";
        $this->patternHandle(new \System\Feature\Collection($uri));
        $this->method = $method;
        return $this;
    }

    public function put($uri, Array|Object|String $method)
    {
        $this->http = "PUT";
        $this->uri = trim($uri, '/');
        $this->method = $method;
        return $this;
    }

    public function delete($uri, Array|Object|String $method)
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

    private function nameHandler($name)
    {
        $count = 1;
        if  (!empty($name)) {

            for ($i=0; $i < count(RouteCollection::$name); $i++) { 
                if (RouteCollection::$name[$i] == $name) {
                    $method = (is_callable($this->route['method'])) ? $count+=1 : $this->route['method'];
                    $this->route['name'] = $name.".".$method;
                }
            }

            RouteCollection::$name[] = $name;
    
            
        }
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

            RouteCollection::$id++;

            $controller = (empty(Container::get('controller'))) ? $this->controller : Container::get('controller');
            $middleware = (!empty($this->midware)) ? $this->midware : Container::get('middleware');
            $http = (!empty($this->http)) ? $this->http : Container::get('http');
            $uri = (!empty($this->uri)) ? $this->uri : Container::get('uri');
            $method = (!empty($this->method)) ? $this->method : Container::get('method');
            $name = (!empty($this->name)) ? $this->name : Container::get('name');

            $uri = (!empty(Container::get('prefix'))) ? $this->prefixHandle($uri) : $uri;
            $uri = (\Application\Signal::getService()) ? 'api/'.trim($uri, '/') : trim($uri, '/');

            $this->route = [
                'id' => RouteCollection::$id,
                'http' => $http,
                'uri' => $uri,
                'controller' => $controller,
                'method' => $method,
                'middleware' => $this->setMiddleware($middleware),
                'name' => $name
            ];
            
            $this->nameHandler($this->route['name']);
            if (!empty($this->route['uri'])) \System\Routing\RouteCollection::add($this->route);
            $this->dispatcher(new Request, $this->route);
        }
    }

}