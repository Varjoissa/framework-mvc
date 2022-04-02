<?php

// Temporary Admin controller

namespace app\controllers\Admin;

use core\View;

class Users extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        echo "This is Controller 'Admin' and Action 'Users'.";
    }


    // ACTION FILTERS
    protected function before()
    {
    }

    protected function after()
    {
    }
}
