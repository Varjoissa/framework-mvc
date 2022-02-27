<?php

// Temporary Posts controller

namespace app\controllers;

class Posts extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        echo "This is Controller 'Posts' and Action 'Index'.";
        echo htmlspecialchars(print_r($_GET, true));
    }

    public function addNewAction()
    {
        echo "This is Controller 'Posts' and Action 'addNew'.";
    }

    public function editAction()
    {
        echo "This is Controller 'Posts' and Action 'edit' with parameters: <br><pre>";
        echo htmlspecialchars(print_r($this->route_params, true)) . '</pre>';
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
