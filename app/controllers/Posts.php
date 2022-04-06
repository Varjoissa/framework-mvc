<?php

// Temporary Posts controller

namespace app\controllers;

use core\View;
use app\models\Post;

class Posts extends \core\Controller
{
    // ACTIONS
    public function indexAction()
    {
        $posts = Post::getAll();
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
