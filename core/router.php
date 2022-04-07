<?php

/*
    MVC Router class

    Created: 2022-02-13
    Updated: 2022-02-21

    Varjoissa

    ## 2022-02-27       
    - Renamed method    prompt() -> dispatch()

    ## 2022-02-22
    - Added namespace   core
    - Updated           prompt() to dispatch namespace based.
    - Added method      trimQueryString() to extract route from url.

    ## 2022-02-21
    - Created array     $params; to hold all params for the matched route.
    - Created method    getParams; to get all params for current match
    - Created method    match(); to check if URL is found in routing table
    - Created method    prompt(); to dispatch the url to the given controller

    ## 2022-02-13
    - Created class
    - Created array     $routes; to hold all routes
    - Created method    add(); to add routes to routing table

*/

namespace Core;

class Router
{
//  **** GENERAL VARIABLES **************************************************
    protected $routes = [];
    protected $params = [];

//  **** SETTERS ************************************************************

//  **** GETTERS ************************************************************

    // GET all parameters (for currently matched route)
    function getParams()
    {
        return $this->params;
    }

    // GET all routes
    function getRoutes()
    {
        return $this->routes;
    }

    protected function getNamespace()
    {
        $namespace = 'app\controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }



//  **** PUBLIC ************************************************************
    
    // ADD dynamic route (regular expression) to routing table 
    //      $route (string)     : Route URL
    //      $params (array)     : Controller, action etc.
    public function add($route, $params = [])
    {
        // Regex: Escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Regex: Formulate params
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Regex: Get custom params
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Regex: Add start and end
        $route = '/^' . $route . '$/i';
        
        $this->routes[$route] = $params;
    }

    // Redirects the url to given controller/action
    public function dispatch($url)
    {
        
        $url = $this->trimQueryString($url);
        
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertString($controller, 'studly');
            $controller = $this->getNamespace() . "$controller";
            
            if (class_exists($controller)) {
                $controller_obj = new $controller($this->params);
                
                $action = $this->params['action'];
                $action = $this->convertString($action, 'camel');

                if (preg_match('/action$/i', $action) == 0) {
                    $controller_obj->$action();
                } else {
                    echo "Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method";
                    exit();
                }
            } else {
                echo "Controller class $controller not found. (#404)";
            }
        } else {
            echo "No route found for url " . urlencode($url) . ". (#404)";
        }
    }



    // MATCH url with routing table.
    //      $url (string)       : Route URL to match
    //      return (boolean)    : Match is succesfull or not
    public function match($url)
    {
        
        foreach ($this->routes as $route => $params) {
            // Extract routing params from URL
            
            if (preg_match($route, $url, $matches)) {
                // Loop through params and get the named params
                
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                // Set params to current params
                $this->params = $params;
                return true;
            }
        }

        return false;
    }

//  **** TOOLS *************************************************************

    // Converts a string to StudlyString or camelCase.
    protected function convertString($string, $output) 
    {
        switch ($output) {
            case 'studly':
                return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
                break;
            case 'camel':
                return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
                break;
            default:
                return $string;
        }
    }

    // Trims query string variables from the url to extract the route
    protected function trimQueryString($url) 
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                 $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
}
