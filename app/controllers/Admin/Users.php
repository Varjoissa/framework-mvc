<?php

// Temporary Admin controller

namespace App\Controllers\Admin;

use Core\View;

class Users extends \Core\Controller
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
