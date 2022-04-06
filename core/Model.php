<?php

namespace core;

abstract class Model
{
    // Returns the database connection
    protected static function getDB()
    {
        static $DB = null;

        // Create new database connection if it doesnt exist yet
        if ($DB === null) {
            $dbSettings = parse_ini_file("../env/database.ini");
            $DB = new \core\Handlers\MYSQL_CONNECTION($dbSettings['host'], $dbSettings['database'], $dbSettings['username'], $dbSettings['password']);
            return $DB;
        }
    }
}
