<?php

/*
    Front controller

    Created: 2022-02-13
    Updated: 2022-02-21

    Varjoissa

    ## 2022-02-21
    - Added some basic routes 
*/

require '../core/router.php';

// $requestURL = $_SERVER['QUERY_STRING'];

// Create new ROUTER
$ROUTER = new MVC_ROUTER();

// echo get_class($ROUTER);

// Create routes
$ROUTER->add('', ['controller' => 'Home', 'action' => 'index']);
$ROUTER->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$ROUTER->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);

echo '<pre>';
print_r($ROUTER->getRoutes());
echo '</pre>';
