<?php

/*
    View class

    Created: 2022-02-13
    Updated: 2022-04-09

    Varjoissa

*/

namespace Core;

class View
{
    // Escapes malicious output; for every value, passed to the view
    protected function escapeOutput($args = [])
    {
        // Loop through the arguments
        foreach ($args as $key => $value) {
            // If its an array, call this function again to loop to that array as well
            if (is_array($value)) {
                $args[$key] = $this->escapeOutput($value);
            } else {
                // Escape output for the value; and pass it back into the array
                $args[$key] = htmlspecialchars($value);
            }
        }
        return $args;
    }

    // Calls the View; with passed values
    public static function render($view, $args = [])
    {
        // Escaping malicious arguments
        $args = (new View())->escapeOutput($args);

        // Extract all arguments into their according variable name.
        /**
         * All argument names are defined based on their own (associative) array key name
         */
        extract($args, EXTR_PREFIX_SAME, "self");
        
        // Define view; relative to Core namespace
        $file = "../App/Views/$view"; 

        // Call view if it is available
        if (is_readable($file)) {
            require $file;
        } else {
            // Throw exception 404 - Not Found
            throw new \Exception("$file not found", 404); 
        }
    }
}
