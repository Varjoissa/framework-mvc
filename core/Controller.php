<?php

/*
    Base Controller

    Created: 2022-02-23
    Updated: 2022-02-23

    Varjoissa

    ## 2022-02-23
    - Created class    Controller

*/

namespace Core;

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
        $method = $name . "Action";

        if (method_exists($this, $method)) {
            // BEFORE
            if ($this->before() !== false) {
            // ACTION
                call_user_func_array([$this, $method], $args);
            // AFTER
                $this->after();
            }
        } else {
            echo "Method $method not found in controller " . get_class($this) . " (#404)"; // Will be 404 page later on
        }
    }

    protected function before()
    {
    }

    protected function after()
    {
    }
}
