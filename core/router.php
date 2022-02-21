<?php

/*
    MVC Router class

    Created: 2022-02-13
    Updated: 2022-02-21

    Varjoissa

    ## 2022-02-21
    - Created array     $params; to hold all params for the matched route.
    - Created method    getParams; to get all params for current match
    - Created method    match(); to check if URL is found in routing table

    ## 2022-02-13
    - Created class
    - Created array     $routes; to hold all routes
    - Created method    add(); to add routes to routing table

*/

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
}
