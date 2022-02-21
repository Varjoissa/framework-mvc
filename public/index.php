<?php

/*
    Front controller

    Created: 2022-02-13
    Updated: 2022-02-21

    Varjoissa

    ## 2022-02-21
    - Added routes      routes; to routing table
    - Added check       match URL through router
    
    ## 2022-02-13
    - Created index     front controller
    - Included file     router.php
    - Created object    $ROUTER

*/

// Include Router
require '../core/Router.php';

// Create new ROUTER
$ROUTER = new Router();

// Create routes
$ROUTER->add('', ['controller' => 'Home', 'action' => 'index']);
$ROUTER->add('{controller}/{action}');
$ROUTER->add('{controller}/{id:\d+}/{action}');
$ROUTER->add('admin/{action}/{controller}');


// Fetch the Route from the URL/Query string
$URL = $_SERVER['QUERY_STRING'];

// Match requested URL to a route in the routing table
if ($ROUTER->match($URL)) {
    // Exists in routing table
    debugInfo($ROUTER);
} else {
    // No match in routing table (#404)
    echo 'No route found for URL: ' . $URL;
}


function debugInfo(&$ROUTER)
{
    echo '<pre>';
    // echo htmlspecialchars(print_r($ROUTER->getRoutes(), true));
    // echo '<br>';
    echo htmlspecialchars(print_r($ROUTER->getParams(), true));
    echo '</pre>';
}
