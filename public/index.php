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

// Create routes (routing table)
$ROUTER->add('', ['controller' => 'Home', 'action' => 'index']);
$ROUTER->add('{controller}/{action}');
$ROUTER->add('{controller}/{id:\d+}/{action}');
$ROUTER->add('admin/{action}/{controller}', ['namespace' => 'Admin']);

// Dispatch route
$ROUTER->dispatch($_SERVER['QUERY_STRING']);
