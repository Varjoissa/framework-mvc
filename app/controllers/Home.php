<?php

// Temporary Home controller

namespace app\controllers;

class Home extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        echo "This is Controller 'Home' and Action 'Index'.";
    }

    // ACTION FILTERS
    protected function before()
    {
        echo "(before) ";
    }

    protected function after()
    {
        echo " (after)";
    }
}
