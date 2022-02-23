<?php

/*
    Base Controller

    Created: 2022-02-23
    Updated: 2022-02-23

    Varjoissa

    ## 2022-02-23
    - Created class    Controller

*/

namespace core;

abstract class Controller
{
    protected $route_params = [];

    // Constructor
    public function __construct($route_params) 
    {
        $this->route_params = $route_params;
    }

    public function __call($name, $args) 
    {
        // BEFORE

        // ACTION
        call_user_func_array([$this, $name], $args);

        // AFTER
    }
}
