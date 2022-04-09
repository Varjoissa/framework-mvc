<?php

/*
    Base Controller


    Created: 2022-02-23
    Updated: 2022-04-09

    Varjoissa

*/

namespace Core;

abstract class Controller
{
    protected $route_params = [];

    // Constructor; imports all route parameters
    public function __construct($route_params) 
    {
        $this->route_params = $route_params;
    }

    // Guides request to Action
    /**
     * This magic method is called from the dispatcher
     * Performs three steps:
     * 1. Before - All checks before allowing Action to happen
     * 2. Action - The Action for the request
     * 3. After - All processes after performing the action
     */ 
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
            // Throw exception 404 - Not Found
            throw new \Exception("Method $method not found in controller " . get_class($this) . ".", 404);
            //echo "Method $method not found in controller " . get_class($this) . " (#404)"; 
        }
    }

    // Base Before method. Can be overridden by called Controllers
    protected function before()
    {
    }

    // Base After method. Can be overridden by called Controllers
    protected function after()
    {
    }
}
