<?php

/*
    Front controller

    Created: 2022-02-13
    Updated: 2022-02-27

    Varjoissa

    ## 2022-02-27
    - Added param       namespace to Routing table (Routing table needs to be seperated later)
    - Changed call      $ROUTER->prompt() to $ROUTER->dispatch()

    ## 2022-02-22
    - Added autoloader  Controller autoloader

    ## 2022-02-21
    - Added routes      Dynamic routes; adding Regex to routing table
    - Added prompt      Dispatches URL to Controller/Action
    
    ## 2022-02-13
    - Created index     front controller
    - Included file     router.php
    - Created object    $ROUTER

*/

// Class Autoloader
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});

// Include Router
require '../core/Router.php';

// Create new ROUTER
$ROUTER = new core\Router();

$routing_table = json_decode(file_get_contents('../core/routing_table.json'), true);
foreach ($routing_table as $route) {
    $ROUTER->add($route['route'], $route['params']);
}

// // Dispatch route
if ($ROUTER->verify($_SERVER['QUERY_STRING'])) {
    $ROUTER->dispatch($_SERVER['QUERY_STRING']);
} else {
    echo "Your request URL is denied.";
}
