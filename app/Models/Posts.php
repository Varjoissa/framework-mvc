<?php

namespace App\Models;

class Posts extends \Core\Model
{
    // Get all data from posts
    public static function getAll()
    {
        $DB = static::getDB();
        $data = $DB->query('SELECT * FROM posts');
        return $data;
    }
}
