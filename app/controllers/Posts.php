<?php

// Temporary Posts controller

namespace app\controllers;

class Posts
{
    public function index()
    {
        echo "This is Controller 'Posts' and Action 'Index'.";
        echo htmlspecialchars(print_r($_GET, true));
    }

    public function addNew()
    {
        echo "This is Controller 'Posts' and Action 'addNew'.";
    }
}
