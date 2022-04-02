<?php

// Temporary Posts controller

namespace app\controllers;

use core\View;

class Posts extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        View::render('Posts/index.php');
    }

    public function addNewAction()
    {
        View::render('Posts/addNew.php');
    }

    public function editAction()
    {
        View::render('Posts/edit.php', $this->route_params);
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
