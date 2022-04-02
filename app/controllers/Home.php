<?php

// Temporary Home controller

namespace app\controllers;

use core\View;

class Home extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        View::render('Home/index.php');
    }

    // ACTION FILTERS
    protected function before()
    {
    }

    protected function after()
    {
    }
}
