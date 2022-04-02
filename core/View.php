<?php

/*
    View class
*/

namespace core;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_PREFIX_SAME, "self");
        
        $file = "../app/views/$view"; // Relative to core

        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found"; // 404 page error later on
        }
    }
}
