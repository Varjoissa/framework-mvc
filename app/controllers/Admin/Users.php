<?php

// Temporary Admin controller

namespace app\controllers\Admin;

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
        echo "(before) ";
    }

    protected function after()
    {
        echo " (after)";
    }
}
