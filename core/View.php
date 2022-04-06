<?php

/*
    View class
*/

namespace core;

class View
{
    // Escapes output for every value, passed to the view
    protected function escapeOutput($args = [])
    {
        foreach ($args as $key => $value) {
            if (is_array($value)) {
                $args[$key] = $this->escapeOutput($value);
            } else {
                $args[$key] = htmlspecialchars($value);
            }
        }
        return $args;
    }

    // Calls the specific view with passed values
    public static function render($view, $args = [])
    {

        $args = (new View())->escapeOutput($args);

        extract($args, EXTR_PREFIX_SAME, "self");
        
        $file = "../app/views/$view"; // Relative to core

        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found"; // 404 page error later on
        }
    }
}
