<?php

// Temporary Posts controller

namespace App\Controllers;

use Core\View;

// use App\Models\Posts;

class Posts extends \Core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        $posts = \App\Models\Posts::getAll();
        View::render('Posts/index.php', ['posts' => $posts]);
    }

    public function addNewAction()
    {
        View::render('Posts/addNew.php');
    }

    public function editAction()
    {
        View::render('Posts/edit.php', $this->route_params);
    }

    public function testAction()
    {
        View::render('Posts/test.php', $this->route_params);
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
