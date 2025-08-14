<?php

namespace Core;
class Router
{


    protected $routes = [];

    public function get($uri, $controller)
    {
        $this->add($uri, $controller, 'GET');
        return $this;
    }

    public function post($uri, $controller)
    {
        $this->add($uri, $controller, 'POST');
        return $this;

    }

    public function patch($uri, $controller)
    {
        $this->add($uri, $controller, 'PATCH');
        return $this;

    }

    public function put($uri, $controller)
    {
        $this->add($uri, $controller, 'PUT');
        return $this;

    }

    public function delete($uri, $controller)
    {
        $this->add($uri, $controller, 'DELETE');
        return $this;

    }

    public function add($uri, $controller, $method)
    {

        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => '',
        ];

    }

    public function all_routes()
    {
        return $this->routes;
    }

    public function routes($uri, $method)
    {
        foreach ($this->routes as $route) {
            // Convert URI with {param} into regex
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route['uri']);
            $pattern = "#^" . $pattern . "$#";
            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {
                array_shift($matches); // First match is the full URI, remove it
                list($class, $controllerMethod) = explode('@', $route['controller']);
                $middleware = (require(base_path('config.php')))['middleware'];
                foreach ($middleware as $key => $mdl) {
                    if ((is_array($route['middleware']) && in_array($key, $route['middleware']))
                        || (!is_array($route['middleware']) && $key === $route['middleware'])) {
                        if (method_exists($mdl, 'handle')) {
                            $mdl::handle();
                        }

                    }
                }
                require controller_path($class);

                $controller = new $class;
                // Call method with matched parameters

                call_user_func_array([$controller, $controllerMethod], $matches);
                exit;
            }
        }

        abort();
    }

    public function only($middleware = [])
    {
        $lastIndex = array_key_last($this->routes);
        $this->routes[$lastIndex]['middleware'] = $middleware;
        return $this;
    }


}