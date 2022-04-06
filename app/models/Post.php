<?php

namespace app\models;

class Post extends \core\Model
{
    // Get all data from posts
    public static function getAll()
    {
        $DB = static::getDB();
        $data = $DB->query('SELECT * FROM posts');
        return $data;
    }
}
