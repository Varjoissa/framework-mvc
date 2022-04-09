<?php

/*
    Front controller

    Created: 2022-02-13
    Updated: 2022-04-09

    Varjoissa

*/

// Class Autoloader
/**
 * Tests if classname exists in the matching filename, then imports it.
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});

// Router Creation
require '../Core/Router.php';
$ROUTER = new core\Router();

// Routing-Table importing from JSON file
$routing_table = json_decode(file_get_contents('../Core/routing_table.json'), true);
foreach ($routing_table as $route) {
    $ROUTER->add($route['route'], $route['params']);
}

// Route dispatching; to its according Controller and Action
/**
 * Uses query string, not complete URL path. 
 * Check if .htaccess file has the required settings for this.
 */
$ROUTER->dispatch($_SERVER['QUERY_STRING']);
