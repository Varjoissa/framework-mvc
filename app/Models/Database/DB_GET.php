<?php

namespace App\Models\Database;

use Exception;

class DB_GET extends \Core\Model
{
    // Get all data from posts
    public static function getAll($FROM)
    {
        $DB = static::getDB();
        $data = $DB->query("SELECT * FROM $FROM");
        return $data;
    }

    // Get all data from posts
    public static function getAllConditional($FROM, $WHERE_REQ = [], $WHERE_ARR = [])
    {
        $DB = static::getDB();

        if (count($WHERE_REQ) != count($WHERE_ARR)) {
            throw new Exception("Database query is empty, but expects conditions.", 500);
        } elseif (count($WHERE_REQ) == 0 && count($WHERE_ARR) == 0) {
            throw new Exception("Database query is empty, but expects conditions.", 500);
        } else {
            $WHERE = "";
            for ($i = 0; $i < count($WHERE_REQ); $i++) {
                if (strlen($WHERE) > 0) {
                    $WHERE .= ", ";
                }
                $WHERE .= $WHERE_REQ[$i] . "= ?";
            }

            $data = $DB->query("SELECT * FROM $FROM WHERE $WHERE", $WHERE_ARR);
            return $data;
        }
    }

    public static function getSpecific($FROM, $WHERE_REQ, $WHEREVAL)
    {
    }
}
