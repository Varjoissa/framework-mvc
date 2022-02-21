<?php

/*
    MVC Router

    Created: 2022-02-13
    Updated: 2022-02-13

    Varjoissa

*/

class MVC_ROUTER 
{

    protected $routes = [];

    // SETTERS

    // GETTERS
        function getRoutes() {
            return $this->routes;
        }
    // PUBLIC

        /* ADD route to routing table
            $route (string)     : Route URL
            $params (array)     : Controller, action etc.
        */
    public function add($route, $params) {
        $this->routes[$route] = $params;
    }
}