<?php

/*
    Front controller

    Created: 2022-02-13
    Updated: 2022-02-21

    Varjoissa

    ## 2022-02-21
    - Added routes      Dynamic routes; adding Regex to routing table
    - Added prompt      Dispatches URL to Controller/Action
    
    ## 2022-02-13
    - Created index     front controller
    - Included file     router.php
    - Created object    $ROUTER

*/

// Controllers
// require '../application/Controllers/Posts.php';

// Autoloader
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

// Create routes
$ROUTER->add('', ['controller' => 'Home', 'action' => 'index']);
$ROUTER->add('{controller}/{action}');
$ROUTER->add('{controller}/{id:\d+}/{action}');
$ROUTER->add('admin/{action}/{controller}');

$ROUTER->prompt($_SERVER['QUERY_STRING']);









// // **** DEBUGGING ***********************************************************
// function debugInfo(&$ROUTER)
// {
//     echo '<pre>';
//     // echo htmlspecialchars(print_r($ROUTER->getRoutes(), true));
//     // echo '<br>';
//     echo htmlspecialchars(print_r($ROUTER->getParams(), true));
//     echo '</pre>';
// }
