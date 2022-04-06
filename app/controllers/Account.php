<?php

// Temporary Posts controller

namespace app\controllers;

use core\View;

class Account extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        View::render('Account/index.php');
    }

    public function userAction()
    {
        echo "This will show a user account";
    }

    // ACTION FILTERS
    protected function before()
    {
        // print_r($this->route_params);
    }

    protected function after()
    {
    }
}
