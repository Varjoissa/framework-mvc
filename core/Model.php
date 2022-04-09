<?php

/*
    Model class

    Created: 2022-02-13
    Updated: 2022-04-09

    Varjoissa

*/

namespace Core;

abstract class Model
{
    // Returns the database connection
    protected static function getDB()
    {
        // Define a static DB object
        static $DB = null;

        // Create new database connection if it doesnt exist yet
        if ($DB === null) {
            // Get DB settings from Environment INI
            $dbSettings = (new Config())->getSettings('database');
            
            // Create new SQL connection (Make sure the handler is fit for the SQL type you are running)
            /**
             * Make sure the following things:
             * 1. Check if the handler is fit for the database you are running (Currently MySQL)
             * 2. If the (PDO)handler has options PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION set, to do proper errorhandling through frontcontroller. 
             */
            $DB = new \App\Models\Handlers\SQL_Handler($dbSettings['host'], $dbSettings['database'], $dbSettings['username'], $dbSettings['password']);
            return $DB;
        }
    }
}
