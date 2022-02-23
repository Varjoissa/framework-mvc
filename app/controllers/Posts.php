<?php

// Temporary Posts controller

namespace app\controllers;

class Posts extends \core\Controller
{
    public function index()
    {
        echo "This is Controller 'Posts' and Action 'Index'.";
        echo htmlspecialchars(print_r($_GET, true));
    }

    public function addNew()
    {
        echo "This is Controller 'Posts' and Action 'addNew'.";
    }

    public function edit()
    {
        echo "This is Controller 'Posts' and Action 'edit' with parameters: <br><pre>";
        echo htmlspecialchars(print_r($this->route_params, true)) . '</pre>';
    }
}
