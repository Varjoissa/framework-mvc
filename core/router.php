<?php

/*
    MVC Router class

    Created: 2022-02-13
    Updated: 2022-04-09

    Varjoissa

*/

namespace Core;

class Router
{
//  **** GENERAL VARIABLES **************************************************
    protected $routes = [];
    protected $params = [];

//  **** SETTERS ************************************************************

//  **** GETTERS ************************************************************

    // GET the namespace for the required Controller
    protected function getNamespace()
    {
        // Base namespace
        $namespace = 'app\controllers\\';

        // Checks if sub-namespace is given for the route
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }

    // GET all parameters; for currently matched route
    function getParams()
    {
        return $this->params;
    }

    // GET all routes
    function getRoutes()
    {
        return $this->routes;
    }


//  **** PUBLIC ************************************************************
    
    // ADD dynamic route (based on regular expression) to routing table 
    //      $route (string)     : Route URL
    //      $params (array)     : Controller, Action, Namespace etc.
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

    // Redirects the URL to given Controller/Action
    public function dispatch($url)
    {
        // Trim the Query string from spaces
        $url = $this->trimQueryString($url);
        
        // Checks if URL matches a route in the routing table
        if ($this->match($url)) {
            // Define the right Namespace and Controller
            $controller = $this->params['controller'];
            $controller = $this->convertString($controller, 'studly');
            $controller = $this->getNamespace() . "$controller";
            
            // Checks if Controller exists for the route
            if (class_exists($controller)) {
                $controller_obj = new $controller($this->params);
                
                // Define the right Action within the controller
                $action = $this->params['action'];
                $action = $this->convertString($action, 'camel');

                // Escape direct calls to the Actions within controllers
                // Function to protect bypassing the before/after function calls
                if (preg_match('/action$/i', $action) == 0) {
                    // Calls __call magic method within Base Controller
                    // Action call is made within the __call method
                    $controller_obj->$action();
                } else {
                    // Throw exception 500 - Server Error
                    echo "Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method";
                    exit();
                }
            } else {
                // Throw exception 404 - Not Found
                echo "Controller class $controller not found. (#404)";
            }
        } else {
            // Throw exception 404 - Not Found
            echo "No route found for url " . urlencode($url) . ". (#404)";
        }
    }



    // MATCH url with routing table
    //      $url (string)       : Route URL to match
    //      return (boolean)    : Match is succesfull or not
    public function match($url)
    {
        
        // Loop through all routes
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

    // Trims query string variables from the URL to extract the route
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
