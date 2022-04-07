<?php

// Temporary Home controller

namespace App\Controllers;

use Core\View;

class Home extends \Core\Controller
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
